@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <h2 class="mb-4 h5">{{ __('Short Links') }}</h2>

            <form class="row row-cols-lg-auto g-3 align-items-center" method="POST" action="{{ route('shortener.submit') }}">
                @csrf
                <div class="col-12">
                  <label class="visually-hidden" for="link">URL</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="link" name="link" placeholder="URL to be shortened.">
                  </div>
                </div>

                <div class="col-12">
                  <button type="submit" class="btn btn-primary">Execute</button>
                </div>
              </form>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('Short URL') }}</th>
                        <th class="border-gray-200">{{ __('Original URL') }}</th>
                        <th class="border-gray-200"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($links as $link)
                        <tr>
                            <td>
                                <a href="{{ route('shortenedurl', ['hashid' => $link->hash]) }}">{{ route('shortenedurl', ['hashid' => $link->hash]) }}</a>
                                <button class="btn btn-sm btn-primary" onclick="copyUrl('{{ route('shortenedurl', ['hashid' => $link->hash]) }}')">
                                    <i class="fa fa-solid fa-copy"></i>
                                </button>
                            </td>
                            <td><a href="{{ $link->original_link }}">{{ $link->original_link }}</a></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function copyUrl(url){
            if (!navigator.clipboard) {
                return alert('Clipboard not supported'); // Clipboard API not supported
            }
            navigator.clipboard.writeText(url).then(function() {
                alert("Copying to clipboard was successful!");
            }, function(err) {
                alert("Copying to clipboard failed!", err);
            });
        }
    </script>
@endsection
