<x-message-banner msg="user login successfully" />
<x-message-banner msg="user signup successfully" />



<style>
    .success{
     background-color: lightgreen;
     color: green;
     margin: 3px;   
    }
</style>

<div>
    <h1>Hello {{ $name }}</h1>
    @include('common.header')
    @includeif('common.djbkj')

   <h1>{{ $page }}</h1>
    <p>Waste no more time arguing what a good man should be, be one. - Marcus Aurelius</p>
</div>
