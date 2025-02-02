@extends('admin.layout')
@section('content')

<style>

@import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');

body{
 
  font-family: 'Open Sans', sans-serif;
}

.container h1{
  color: #fff;
  text-align: center;
}

details{
  background-color: #303030;
  color: #fff;
  font-size: 1.5rem;
  margin-top:2px;
}

summary {
  padding: .5em 1.3rem;
  list-style: none;
  display: flex;
  justify-content: space-between;  
  transition: height 1s ease;
  cursor:pointer;
  color:orange;
}

summary::-webkit-details-marker {
  display: none;
}

summary:after{
  content: "\002B";
}

details[open] summary {
    border-bottom: 1px solid #aaa;
    margin-bottom: .5em;
}

details[open] summary:after{
  content: "\00D7";
}

details[open] div{
  padding: .5em 1em;
}

</style>

<br />
<br />
<br />
<div class="container">

  <h2 class="text-center">Frequently Asked Questions</h2>

  @foreach($faq as $item)
  <details>
  <summary>{{$item->faq_title ?? ''}}</summary>
  <div>
  {{$item->faq_desc ?? ''}}
  </div>
</details>
@endforeach



</div>

<br />
<br />
<br />

@endsection