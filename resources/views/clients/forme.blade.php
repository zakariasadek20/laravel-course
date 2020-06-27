    <div class="form-group">
      <label for="nom">Nom : </label>
      <input class="form-control" id="nom" name="nom" type="text" value="{{old('nom',$client->nom ?? null)}}">
    </div>
    <div class="form-group">
      <label for="prenom"> Prenom : </label>
      <input class="form-control" id="prenom" name="prenom" type="text" value="{{old('prenom',$client->prenom ?? null)}}">
    </div>
    <div class="form-group">
      <label for="email"> Email : </label>
      <input class="form-control" id="email" name="email" type="text" value="{{old('email',$client->email ?? null)}}">
    </div>
    <div class="form-group">
      <label for="tele"> Tele : </label>
      <input class="form-control" id="tele" name="tele" type="text" value="{{old('tele',$client->tele ?? null)}}">
    </div>
    @if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
      <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif