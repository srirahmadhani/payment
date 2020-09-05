@extends('layouts.main')
@section('title') Edit Tiket @endsection

@section('heading')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800"></h1>
</div>
@endsection

@section('content')
<div class="container">
<div class="card">
<div class="card-header"> <h6 class="m-0 font-weight-bold text-primary">Edit <b>{{$ticket->ticket_name}}</b></h6>
</div>
<div class="card-body">
<form method="POST" action="{{route('ticket.update',$ticket->ticket_id)}}" enctype="multipart/form-data">
   @csrf
   <div class="form-group">
      <label for="id">ID</label>
      <input type="text" class="form-control"  id="id" name="id" 
         value="{{$ticket->ticket_id}}"readonly>
   </div>
   <div class="form-group">
      <label for="name">Nama Kategori</label>
      <input type="text" class="form-control" id="name" 
         placeholder="Masukkan Nama" name="name"  value="{{$ticket->ticket_name}}" 
         required>
   </div>
   <div class="form-group">
      <label for="price">Tarif</label>
      <input type="number" class="form-control " id="price" name="price" 
         value="{{$ticket->price}}" required>
   </div>
   <div class="form-group">
      <label for="image">Gambar</label>
      <input type="file" class="form-control" id="image"
         placeholder="Masukkan Gambar" name="image"  value="{{ old('image') }}" accept="image/*" required>

   </div>
   <div class="form-group">
      <label for="info"> Keterangan</label>
      <input type="text" class="form-control" id="info" name="info"  
         value="{{$ticket->info}}" required>
   </div>
   <button type="submit" class="btn btn-primary">Submit</button>
  
</form>
@endsection