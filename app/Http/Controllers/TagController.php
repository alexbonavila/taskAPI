<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    protected $tagTransformer;
    /**
     * tagController constructor.
     * @param $tagTransformer
     */
    public function __construct(tagTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
        $this->middleware('auth.basic', ['only' => 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tag = tag::all();
        return $this->respond([
            'data' => $this->tagTransformer->transformCollection($tag->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (! Input::get('name') or ! Input::get('done') or ! Input::get('priority'))
        {
            return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
                ->respondWithError('Parameters failed validation for a tag.');
        }
        tag::create(Input::all());
        return $this->respondCreated('tag successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = tag::find($id);
        if (!$tag)
        {
            return $this->respondNotFound('tag does not exist');
        }
        return $this->respond([
            'data' => $this->tagTransformer->transform($tag)
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = tag::finOrFail($id);
        $this->savetag($request, $tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        tag::destroy($id);
    }
}
