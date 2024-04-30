@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <h2 class="mb-4 h5">{{ __('Whois Results') }}</h2>

            <form class="row row-cols-lg-auto g-3 align-items-center" method="POST" action="{{ route('whois.submit') }}">
                @csrf
                <div class="col-12">
                  <label class="visually-hidden" for="host">hostname</label>
                  <div class="input-group">
                    <div class="input-group-text">whois</div>
                    <input type="text" class="form-control" id="host" name="host" placeholder="Hostname">
                  </div>
                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-primary">Execute</button>
                </div>
              </form>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('Host') }}</th>
                        {{-- <th class="border-gray-200">{{ __('Finished') }}</th> --}}
                        <th class="border-gray-200"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resulthash as $whois)
                        <tr>
                            <td><span class="fw-normal">{{ $whois->host }}</span></td>
                            {{-- <td><span class="fw-normal">{{ \Carbon\Carbon::parse($whois->updated_at) }}</span></td> --}}
                            <td>
                                <div class="bg-dark">
                                    <pre>
                                        <code>
                                            {!! $whois->result !!}
                                        </code>
                                    </pre>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
