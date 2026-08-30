@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row">
        {{-- বাম পাশ: নতুন ছুটি যোগ করার ফর্ম --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title text-primary">{{ __('Add New Holiday') }}</h6>
                    <form action="{{ route('holidays.store', ['tenant' => $tenant]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Holiday Title') }}</label>
                            <input type="text" name="title" class="form-control" placeholder="{{ __('e.g. Eid-ul-Fitr') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Date') }}</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">{{ __('Save Holiday') }}</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ডান পাশ: ছুটির তালিকা --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Holiday List') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Day') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($holidays as $holiday)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $holiday->title }}</td>
                                    <td>{{ date('d M, Y', strtotime($holiday->date)) }}</td>
                                    <td>{{ __(date('l', strtotime($holiday->date))) }}</td>
                                    <td>
                                        <form action="{{ route('holidays.destroy', [$tenant, $holiday->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                <i data-feather="trash-2" class="icon-sm"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">{{ __('No holidays found.') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $holidays->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection