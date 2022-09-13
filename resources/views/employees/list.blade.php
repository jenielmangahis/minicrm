@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'employees',
])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Employees') }}
                    <a href="{{ route('employee.create') }}" class="btn btn-sm btn-primary" style="margin-left: 10px;">{{ __('Add Employee') }}</a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow">
                                <div class="card-header border-0">
                                    <div class="row align-items-center">                                        
                                        <div class="col-4 text-right">
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    @if (session('status'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('status') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>                                                
                                                <th scope="col">{{ __('Company') }}</th>
                                                <th scope="col">{{ __('Name') }}</th>
                                                <th scope="col">{{ __('Email') }}</th>
                                                <th scope="col">{{ __('Phone') }}</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $emp)
                                                <tr>
                                                    <td>{{ $emp->company->name }}</td>
                                                    <td>{{ $emp->first_name . ' ' . $emp->last_name }}</td> 
                                                    <td>{{ $emp->email }}</td>                                        
                                                    <td>{{ $emp->phone }}</td>                                        
                                                    <td>
                                                        <div class="dropdown">
                                                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                          </button>
                                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <?php $eeid =  Hashids::encode($emp->id); ?>
                                                            <form action="{{ route('employee.destroy', $eeid) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <a class="dropdown-item" href="{{ route('employee.edit', $eeid) }}">{{ __('Edit') }}</a>
                                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this employee?") }}') ? this.parentElement.submit() : ''">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>  
                                                          </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <nav class="d-flex justify-content-end" aria-label="...">
                                        {{ $employees->links('pagination::bootstrap-4') }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
