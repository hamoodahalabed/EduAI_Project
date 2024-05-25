<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\AuthTrait;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    use AuthTrait;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function loginForm($type){
       
        return view('auth.login',compact('type'));
    }

    public function login(Request $request){

        $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);
    
        if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->redirect($request);
        } else {
            $message = '';

            if ($request->type === 'admin') {
                if (!User::where('email', $request->email)->exists()) {
                    return redirect()->back()->with('message', __('auth.invalid_credentials1'));
                } else {
                    return redirect()->back()->with('message', __('auth.invalid_credentials2'));
                }
               
            }
            if ($request->type === 'teacher') {
                if (!Teacher::where('email', $request->email)->exists()) {
                    return redirect()->back()->with('message', __('auth.invalid_credentials1'));
                } else {
                    return redirect()->back()->with('message', __('auth.invalid_credentials2'));
                }
            }
            if ($request->type === 'student') {
                if (!Student::where('email', $request->email)->exists()) {
                    return redirect()->back()->with('message', __('auth.invalid_credentials1'));
                } else {
                    return redirect()->back()->with('message', __('auth.invalid_credentials2'));
                }            }
        }
    }
    
    public function logout(Request $request,$type)
    {
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function sendMail(Request $request)
    {
        
        
        require base_path('vendor/autoload.php');
        $mail = new PHPMailer(true);
        try {
            $type=$request->user_type;
            $user;
            if($request->user_type == 'student') {
                $user = \App\Models\Student::where('email', $request->user_email)->first();
            } elseif($request->user_type == 'teacher') {
                $user = \App\Models\Teacher::where('email', $request->user_email)->first();
            } else {
                $user = \App\Models\User::where('email', $request->user_email)->first();
            }
            
            if($user === null) {
                $isError=2;
                session()->flash('msg', 'Your email is not correct');
                return view('auth.login',compact('type','isError'));
            }
                // Define the characters we want in our password
                $lowercase = 'abcdefghijklmnopqrstuvwxyz';
                $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $numbers = '0123456789';
                $special_chars = '!@#$%^&*()';
        
                // Initialize the password with one character from each group
                $password = [
                    $lowercase[rand(0, 25)],
                    $uppercase[rand(0, 25)],
                    $numbers[rand(0, 9)],
                    $special_chars[rand(0, 9)]
                ];
        
                // Fill the rest of the password with random characters from all groups
                $all_chars = $lowercase . $uppercase . $numbers . $special_chars;
                for ($i = 0; $i < 4; $i++) {
                    $password[] = $all_chars[rand(0, strlen($all_chars) - 1)];
                }
        
                // Shuffle the password to ensure it's not predictable
                shuffle($password);
                
                // Convert the password array back to a string
                $password = implode('', $password);
        
               
                $user->password= Hash::make($password);
                
            
            
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = env('Forget_Paswword_email');
            $mail->Password = env('Forget_Paswword_password');
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('Edu@AI.com.jo', 'EduAI');
            $mail->addAddress($user->email);
            
            $mail->isHTML(true);
            $mail->Subject = 'Password Change Request';
            $mail->Body = '<b><h2>Hello '.$user->name.'!<br> <br>This is your new password: </h2><br><h1>'.$password.'</h1><br> <h3 style="color:red;">NOTE: DO NOT SHARE IT WITH ANYONE SO HE\SHE CAN USE YOUR ACCOUNT...</h3></b>';
            $mail->AltBody = 'Hello '.$user->name.'!. This is your new password: '.$password.'...NOTE: DO NOT SHARE IT WITH ANYONE SO HE\SHE CAN USE YOUR ACCOUNT...';
            $mail->send();
            $user->save();
            $isError=1;
            session()->flash('msg', 'Successfully done the operation, Check your email!!');
            return view('auth.login',compact('type','isError'));
        } catch (Exception $e) {
            $isError=2;
            session()->flash('msg', 'Something went wrong. Contact us on (eduai8194@gmail.com)');
            return view('auth.login',compact('type','isError'));
           
        }

}}