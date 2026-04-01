@extends('ordering.partials.layout')
@push('style')
    <style>
        #desk-container {height: calc( 100vh);overflow-y: auto;}
        .cards {
            margin: 0 auto;
            width: 100%;
            /*max-width: 1220px;*/
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(225px, 1fr));
            grid-auto-rows: auto;
            gap: 1rem;
            font-family: sans-serif;
            /*margin-top: 55px;*/
            /*min-height: calc( 100vh - 101px);*/
        }
        .cards .card-btn {box-sizing: border-box;}
        .cards .card {background: transparent;}
        .card .card-body { color: white}
        /*.card .card-body .card-title { height: calc( 100% - 30px); }*/
        .card-descrip { margin: calc(100% - 10.2rem) auto;}
    </style>
@endpush
@section('pages')
    <div class="navtop-hide h-topbar" ></div>
    <div id="desk-container" class="mt-3" data-perfect-scrollbar="true" style="position: relative; height: calc(100vh - 6.30rem);">
        <div class="cards px-3 py-0">
            @foreach($table as $t)
                <form action="{{ route('ordering.table') }}" method="post">
                    @csrf
                    <input type="hidden" name="table" value="{{ $t->id }}">
                    <button type="submit" class="btn btn-block p-0 rounded-9 card-btn">
                        <div class="card {{ $sts[$t->sts] }} text-capitalize rounded-9">
                            <div class="card-body py-3 text-start">
                                <h4 class="card-title d-flex justify-content-between">
                                    <span class="fw-600 fs-3">{{ $t->name }}</span>
                                    <span class="fs-3">{{ $t->odrtm?Date('H:i',strtotime($t->odrtm)):'' }}</span>
                                </h4>
                                <div class="card-content card-descrip"></div>
                                <span class="info fs-5 fw-500">{{ $t->odrcnt?'Ordered '.$t->odrcnt.' items':'No Order' }}</span>
                            </div>
                        </div>
                    </button>
                </form>
                {{--<a href="/ordering/menu/?table={{ $t->id }}" class="btn p-0 rounded-9 card-btn">
                </a>--}}
            @endforeach
        </div>
    </div>
@endsection
