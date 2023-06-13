@extends('layout.main')
@section('content')
<div class="mb-12">
    <div class="pt-[20px] mx-auto w-[837px] relative">
        <form action="/masjid/">
            @if($sort_by != null)
            <input type="hidden" name="sort_by" value="{{ $sort_by }}">
            @endif
        <input name="q" value="{{ $q }}" class="ps-[33px] text-xl w-[834px] h-[48px] shadow-[0_4px_4px_4px_rgba(0,0,0,0.25)] rounded-[30px]" placeholder="Telusuri “Masjid Al-Bukharahi NTT....”" type="text">
        <button class="absolute right-[27px] bottom-[8px]">
            <svg width="30" height="30" viewBox="0 0 35 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25.0143 22.6415H23.4334L22.8731 22.0858C24.902 19.6652 26.0171 16.575 26.0149 13.3791C26.0149 10.7329 25.252 8.14624 23.8227 5.94606C22.3934 3.74589 20.362 2.03106 17.9852 1.01843C15.6084 0.00579694 12.993 -0.259153 10.4698 0.257081C7.94662 0.773316 5.62892 2.04755 3.80979 3.91864C1.99067 5.78974 0.751835 8.17366 0.24994 10.7689C-0.251955 13.3642 0.00563592 16.0543 0.990138 18.499C1.97464 20.9437 3.64183 23.0333 5.7809 24.5034C7.91996 25.9735 10.4348 26.7581 13.0074 26.7581C16.2293 26.7581 19.191 25.5437 21.4723 23.5266L22.0126 24.1029V25.729L32.0183 36L35 32.9331L25.0143 22.6415ZM13.0074 22.6415C8.02459 22.6415 4.00229 18.5043 4.00229 13.3791C4.00229 8.25386 8.02459 4.11664 13.0074 4.11664C17.9903 4.11664 22.0126 8.25386 22.0126 13.3791C22.0126 18.5043 17.9903 22.6415 13.0074 22.6415Z" fill="black"/>
                </svg>
                
            </button>
    </form>
        
    </div>
    
    <div class="mt-[70px] text-right me-[40px]">
        <span class="text-lg text-[#343434] font-semibold me-[10px]">Urutkan Berdasarkan</span>
        <form action="/masjid" id="sort" class="mt-2">
            <input type="hidden" value="{{ $q }}" name="q">
            <select name="sort_by" id="sort_by" onchange="select()" class="font-medium text-[#343434] ps-[10px] w-[175px] h-[60px] rounded-[25px] bg-[#F3F3F3] shadow-[0_2px_2px_2px_rgba(0,0,0,0.25)]">
                <option value="newest" {{ ($sort_by === 'newest')? 'selected' : ''}}>Terbaru</option>
                <option value="oldest" {{ ($sort_by === 'oldest')? 'selected' : ''}}>Terlama</option>
                <option value="luas_asc" {{ ($sort_by === 'luas_asc')? 'selected' : ''}}>Luas Terkecil</option>
                <option value="luas_desc" {{ ($sort_by === 'luas_desc')? 'selected' : ''}}>Luas Terbesar</option>
            </select>
        </form>
        
    </div>
    
    <div class="justify-center grid ms-[30px]">
        <div class="mt-[40px] grid grid-cols-4 gap-y-10 gap-x-7">
            @foreach($masjid as $m)
            <div class="w-[300px] h-[400px] shadow-[0_4px_4px_5px_rgba(0,0,0,0.25)] rounded-[25px]">
                <img src="{{ $m->foto }}" alt="" class="rounded-t-[25px] h-[244px] w-full overflow-hidden">
                <div class="mt-[20px] w-[300px] h-[51px] ms-[20px]">
                    <span class="text-xs text-slate-500">{{ $m->alamat }}</span>
                    <h1 class="text-[23.5px] leading-[35.25px]">{{ $m->nama }}</h1>
                </div>
                <div class="justify-center flex">
                    <a href="/masjid/{{ $m->id }}/detail">
                        <div class="mt-[30px] text-base leading-[35.25px] text-slate-200 bg-[#175729] flex items-center w-[241px] h-[35px] rounded-[25px]"><span class="m-auto">Lihat Selengkapnya</span></div>
                    </a>
                </div>
            </div>
            @endforeach
            <div class="justify-center mb-[30px]">
               <span>{{ $masjid->links() }}</span> 
            </div>
            
        
    
        </div>
    </div>
</div>

@endsection
@push('custom_js')
<script>
function select(){
    document.querySelector('#sort').submit();
}
    
</script>
@endpush