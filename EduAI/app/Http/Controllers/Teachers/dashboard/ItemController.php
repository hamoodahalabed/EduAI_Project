<?php

namespace App\Http\Controllers\Teachers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemsRequest;
use App\Models\Item;
use App\Models\Section;
use App\Repository\ItemRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    protected $Item;
    public function __construct(ItemRepositoryInterface $Item)
    {
        $this->Item = $Item;
    }

    public function saveOrder(Request $request)
    {

        try {
            // Retrieve the tag_order from the request
            $tagOrder = $request->input('tag_order');
            if ($tagOrder === null) {
                return redirect()->back();
            }

            // Split the string into an array of values
            $order = explode(',', $tagOrder);

            // Loop through the order array and update the positions in the database
            foreach ($order as $position => $itemId) {
                $item = Item::find($itemId);
                if ($item) {
                    // Update the position
                    $item->position = $position + 1; // Adjust the position if needed
                    $item->save();
                }
            }

            // Return a redirect response back to the previous page
            return redirect()->back();
        } catch (\Exception $e) {
            // Log the exception message or return it as part of the response
            Log::error('Error saving order: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while saving the order.']);
        }
    }
    public function create($current_id)
    {
        return $this->Item->create($current_id);
    }
    public function create_Youtube_URL($current_id)
    {
        return $this->Item->create_Youtube_URL($current_id);
    }
    

    public function store(StoreItemsRequest $request)
    {
        $request->validate([
            'file_name' => ['required','file','max:40960'],
        ]);
        return $this->Item->store($request);
    }
    public function storeURL(StoreItemsRequest $request)
    {
        $request->validate([
            'file_name' => ['required'],
        ]);
        if ( $request->youtube_url=== null){
        $originalFilename = $request->file('file_name')->getClientOriginalName();

        if (!preg_match('/^[^\p{Emoji}\/|\\:?*"<>\n]*$/u', $originalFilename)) {
            // The original filename contains an emoji or one of the special characters.
            // You can return a custom error message here.
            return back()->withErrors(['file_name' => 'The filename contains invalid characters.']);
        }}
        return $this->Item->storeURL($request);
    }
        public function Upload_attachment(Request $request)
        {
            return $this->Item->Upload_attachment($request);
        }
        public function downloadAttachment($filename)
        {
            return $this->Item->download($filename);
        }

        public function destroy(Request $request)
        {
            // Call the destroy method of the ItemRepository
            return $this->Item->destroy($request);
        }
        public function edit($id,$current_id)
        {
            return $this->Item->edit($id,$current_id);
        }

        public function update(StoreItemsRequest $request)
        {
            return $this->Item->update($request);
        }

    }