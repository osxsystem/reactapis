<?php

namespace App\Http\Controllers\API;

use App\Album;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class AlbumController extends BaseController
{
    public function index()
    {
        $albums = Album::all();

        return $this->sendResponse($albums->toArray(), 'Albums retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title'  		  => 'required',
            'artist' 		  => 'required',
            'url'    		  => 'required',
            'image'           => 'required',
            'thumbnail_image' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $album = Album::create($input);

        return $this->sendResponse($album->toArray(), 'Album created successfully.');
    }

    public function show($id)
    {
        $album = Album::find($id);

        if (is_null($album)) {
            return $this->sendError('Album not found.');
        }

        return $this->sendResponse($album->toArray(), 'Album retrieved successfully.');
    }

    public function update(Request $request, Album $album)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $album->title = $input['title'];
        $album->artist = $input['artist'];
        $album->artist = $input['url'];
        $album->artist = $input['image'];
        $album->artist = $input['thumbnail_image'];
        $album->save();

        return $this->sendResponse($album->toArray(), 'Album updated successfully.');
    }

    public function destroy(Album $album)
    {
        $album->delete();
        return $this->sendResponse($album->toArray(), 'Album deleted successfully.');
    }
}
