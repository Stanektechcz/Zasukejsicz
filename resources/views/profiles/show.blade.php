@extends('layouts.app')

@section('title', $profile->display_name . ' - Profile Detail')

@section('content')
<x-profile-detail :profile="$profile" />
@endsection