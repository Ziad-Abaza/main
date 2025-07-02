<!-- resources/views/dashboard/children_students/index.blade.php -->

@extends('dashboard.layouts.app')
@section('title', 'Children Students - Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col">
            @livewire('dashboard.children-students-table')
        </div>
    </div>
</div>
@endsection
