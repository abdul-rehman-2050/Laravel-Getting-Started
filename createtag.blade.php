
@extends('layouts.app')
@section('title', 'Create Tags')
@section('header')
  <h1 class="text-center text-primary">Create New Tag</h1><hr/>
@endsection
@section('content')
<div class="container">
  <form class="form form-group" action="#" method="post">
     {{ csrf_field() }}
     <div class="row">
       <div class="col-md-3 col-md-offset-4">
          <input class="form-control input-md" placeholder="New Tag Value">
       </div>
       <div class="col-md-3">
         <input type="submit" class="fomr-control btn btn-info" value="Submit New TAG">
       </div>
     </div>
  </form>
</div>
@endsection
