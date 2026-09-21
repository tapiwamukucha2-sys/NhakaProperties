@extends('layouts.admin')

@section('page-title', 'Homepage Copy')

@section('styles')
  .form-panel{background:var(--paper-2); border:1px solid var(--line); border-radius:12px; padding:28px; max-width:720px;}
  .form-panel label{display:block; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.03em; color:rgba(19,28,43,0.55); margin-bottom:6px;}
  .form-panel input[type=text], .form-panel textarea{width:100%; padding:11px 13px; border:1px solid var(--line); border-radius:7px; font-family:inherit; font-size:14px; margin-bottom:20px;}
  .form-panel textarea{resize:vertical; min-height:70px;}
  .form-panel h3{font-size:14px; margin:26px 0 14px; padding-top:20px; border-top:1px solid var(--line);}
  .form-panel h3:first-of-type{margin-top:0; padding-top:0; border-top:none;}
@endsection

@section('content')

<div class="form-panel">
  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <h3>Category cards</h3>

    <label for="category_rent_desc">Rent a home — description</label>
    <input id="category_rent_desc" name="category_rent_desc" type="text" value="{{ old('category_rent_desc', $values['category_rent_desc']) }}">

    <label for="category_buy_desc">Buy a house — description</label>
    <input id="category_buy_desc" name="category_buy_desc" type="text" value="{{ old('category_buy_desc', $values['category_buy_desc']) }}">

    <label for="category_land_desc">Land & stands — description</label>
    <input id="category_land_desc" name="category_land_desc" type="text" value="{{ old('category_land_desc', $values['category_land_desc']) }}">

    <label for="category_commercial_desc">Commercial — description</label>
    <input id="category_commercial_desc" name="category_commercial_desc" type="text" value="{{ old('category_commercial_desc', $values['category_commercial_desc']) }}">

    <h3>Trust section</h3>

    <label for="trust_heading">Heading</label>
    <input id="trust_heading" name="trust_heading" type="text" value="{{ old('trust_heading', $values['trust_heading']) }}">

    <label for="trust_lede">Paragraph</label>
    <textarea id="trust_lede" name="trust_lede">{{ old('trust_lede', $values['trust_lede']) }}</textarea>

    <button type="submit" class="btn btn-primary">Save changes</button>
  </form>
</div>

@endsection
