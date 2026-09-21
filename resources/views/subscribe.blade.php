@extends('layouts.site')

@section('title', 'Subscribe — '.config('app.name'))

@section('styles')
  .sub-wrap{max-width:920px; margin:0 auto; padding:60px 0 90px;}
  .status-banner{padding:16px 20px; border-radius:10px; margin-bottom:30px; font-size:14.5px; font-weight:600;}
  .status-active{background:rgba(18,58,107,0.08); border:1px solid rgba(18,58,107,0.25); color:var(--forest);}
  .status-pending{background:rgba(192,138,40,0.1); border:1px solid rgba(192,138,40,0.3); color:var(--gold);}
  .plan-picker{display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:36px;}
  @media(max-width:800px){ .plan-picker{grid-template-columns:1fr;} }
  .plan-pick{border:2px solid var(--line); border-radius:12px; padding:20px; cursor:pointer; background:var(--paper-2);}
  .plan-pick.selected{border-color:var(--forest); box-shadow:0 0 0 3px rgba(18,58,107,0.1);}
  .plan-pick .amount{font-family:'Fraunces',serif; font-size:26px; font-weight:600; margin-top:6px;}
  .pay-panel{background:var(--paper-2); border:1px solid var(--line); border-radius:14px; padding:32px; display:none;}
  .pay-panel.visible{display:block;}
  .pay-panel label{display:block; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.03em; color:rgba(19,28,43,0.55); margin-bottom:6px; margin-top:18px;}
  .pay-panel input, .pay-panel textarea, .pay-panel select{width:100%; padding:12px 14px; border:1px solid var(--line); border-radius:8px; font-family:inherit; font-size:14.5px;}
  .method-tabs{display:flex; gap:10px; margin-top:8px;}
  .method-tab{flex:1; text-align:center; padding:12px; border:2px solid var(--line); border-radius:8px; cursor:pointer; font-weight:600; font-size:14px;}
  .method-tab.selected{border-color:var(--forest); background:rgba(18,58,107,0.06);}
  .pay-instructions{background:var(--paper); border-radius:10px; padding:18px; margin-top:16px; font-size:14px; line-height:1.7;}
@endsection

@section('content')

<section class="page-hero">
  <div class="wrap">
    <h1>Choose your plan</h1>
    <p>Pick a plan, pay via EcoCash or PayPal, and we'll activate your listing limit once we confirm the payment.</p>
  </div>
</section>

<div class="wrap sub-wrap">

  @if (session('status'))
    <div class="status-banner status-pending">{{ session('status') }}</div>
  @endif

  @if ($activeSubscription)
    <div class="status-banner status-active">
      ✓ You're on the <strong>{{ ucfirst($activeSubscription->plan) }}</strong> plan — {{ $activeSubscription->listingLimit() }} active listings allowed.
      You're currently using {{ auth()->user()->activeListingCount() }}.
    </div>
  @elseif ($pendingSubscription)
    <div class="status-banner status-pending">
      ⏳ Your <strong>{{ ucfirst($pendingSubscription->plan) }}</strong> plan payment is submitted and awaiting verification. We'll activate it as soon as we confirm the payment.
    </div>
  @endif

  <form action="{{ route('subscribe.store') }}" method="POST" id="subscribeForm">
    @csrf

    <div class="plan-picker">
      @foreach ($plans as $key => $plan)
        <label class="plan-pick" data-plan="{{ $key }}">
          <input type="radio" name="plan" value="{{ $key }}" style="display:none;" required>
          <div style="font-weight:700; font-size:13px; text-transform:uppercase; color:var(--forest);">{{ $plan['name'] }}</div>
          <div class="amount">{{ $plan['price'] ? '$'.$plan['price'] : 'Custom' }}@if($plan['period'])<span style="font-size:14px; font-weight:500;"> /mo</span>@endif</div>
          <p style="font-size:13px; color:rgba(19,28,43,0.65); margin-top:8px;">{{ $plan['desc'] }}</p>
        </label>
      @endforeach
    </div>

    <div class="pay-panel" id="payPanel">
      <h3 style="font-size:18px;">Payment method</h3>
      <div class="method-tabs">
        <div class="method-tab" data-method="ecocash">EcoCash</div>
        <div class="method-tab" data-method="paypal">PayPal</div>
      </div>
      <input type="hidden" name="method" id="methodInput" value="ecocash" required>

      <div id="ecocashInstructions" class="pay-instructions">
        Send your plan amount via EcoCash to <strong>+263 77 665 1578</strong> ({{ config('app.name') }}), then fill in the reference below and submit.
      </div>
      <div id="paypalInstructions" class="pay-instructions" style="display:none;">
        Send your plan amount via PayPal to <strong>support@nhaka.co.zw</strong>, then fill in the transaction reference below and submit.
      </div>

      <label for="reference">Transaction reference / confirmation code</label>
      <input id="reference" name="reference" type="text" placeholder="e.g. MP240921.1234.A56789">

      <label for="note">Anything else we should know? (optional)</label>
      <textarea id="note" name="note" rows="2"></textarea>

      <button type="submit" class="btn btn-primary" style="margin-top:24px;">Submit payment claim</button>
      <p style="font-size:13px; color:rgba(19,28,43,0.55); margin-top:12px;">We'll manually verify your payment and activate your plan — usually within a few hours.</p>
    </div>
  </form>
</div>

@endsection

@section('scripts')
<script>
  const picks = document.querySelectorAll('.plan-pick');
  const payPanel = document.getElementById('payPanel');
  picks.forEach(pick => {
    pick.addEventListener('click', () => {
      picks.forEach(p => p.classList.remove('selected'));
      pick.classList.add('selected');
      pick.querySelector('input').checked = true;
      payPanel.classList.add('visible');
    });
  });

  const methodTabs = document.querySelectorAll('.method-tab');
  const methodInput = document.getElementById('methodInput');
  methodTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      methodTabs.forEach(t => t.classList.remove('selected'));
      tab.classList.add('selected');
      methodInput.value = tab.dataset.method;
      document.getElementById('ecocashInstructions').style.display = tab.dataset.method === 'ecocash' ? 'block' : 'none';
      document.getElementById('paypalInstructions').style.display = tab.dataset.method === 'paypal' ? 'block' : 'none';
    });
  });
  document.querySelector('.method-tab[data-method="ecocash"]').classList.add('selected');
</script>
@endsection
