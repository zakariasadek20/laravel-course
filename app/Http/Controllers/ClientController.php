<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientStore;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\Input;


class ClientController extends Controller
{
   
    public function index(){
        return view('clients.index',[
            'clients'=>Client::all()
        ]);
    }
    public function create()
    {
        return view('clients.create');
    }
    public function edit($id){
        $client=Client::findOrFail($id);
        return view('clients.edit',['client'=>$client]);
    }
    public function update(ClientStore $request, $id){
        $client=Client::findOrFail($id);
        $client->nom=$request->input('nom');
        $client->prenom=$request->input('prenom');
        $client->email=$request->input('email');
        $client->tele=$request->input('tele');
        $client->save();
        $request->session()->flash('status','Client was Upadated');
        return redirect()->route('clients.index');
    }
    public function show($id){
        $client=Client::findOrFail($id);
        return view('clients.show',['client'=>$client]);
    }
    public function destroy($id){
        $client=Client::destroy([$id]);
        return redirect()->route('clients.index');
    }
    public function store(ClientStore $request)
    {
        $data=$request->only(['nom','prenom','email','tele']);
        $client=Client::create($data);

        // $validateData=$request->validate([
        //     'name'=>'required|min:4|max:10',
        //     'prenom'=>'required|min:4|max:20',
        //     'telephone'=>'required|min:10|max:13'
        // ]);
        // $client=new Client;
        // $client->name=$request->input('name');
        // $client->prenom=$request->input('prenom');
        // $client->tele=$request->input('telephone');
        // $client->slug=Str::slug($client->title,'-');
           $request->session()->flash('status','client was created');

        // $client->save();
        // return redirect()->route('client.show',['client'=>$client->id]);
        return redirect()->route('clients.index');
    }

   
}
