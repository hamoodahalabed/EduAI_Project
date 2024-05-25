<?php

namespace App\Repository;

use App\Http\Requests\StoreItemsRequest;
use Illuminate\Http\Request;

interface ItemRepositoryInterface{



    //Upload_attachment
    public function Upload_attachment($request);

    //create
    public function create($current_id);
    public function create_Youtube_URL($current_id);
    //store
    public function store(StoreItemsRequest $request);
    public function storeURl(StoreItemsRequest $request);
    //download
    public function download($filename);

    //destroy file
    public function destroy($request);

//edit file
public function edit($id,$current_id);

//update
public function update($request);


}