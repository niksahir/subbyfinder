@extends('layouts.before')
@section('title')
    Subby Finder
@endsection

@section('content')
    <section class="plans-sec">
        <div class="container">
            <div class="col-12">
                <div class="title">
                    <h4>Membership Plans</h4>

                    <div class="radio-btn">
                        <div class="radio-item">
                            <input type="radio" id="month" name="billing" value="monthly" checked>
                            <label for="month">Billed Monthly</label>
                        </div>

                        <div class="radio-item">
                            <input type="radio" id="year" name="billing" value="yearly">
                            <label for="year">Billed Yearly <span>Save 10%</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-0" id="plans-container">
                {{-- Plans will be injected here --}}
            </div>
        </div>

        <form id="checkout-form" method="POST" action="{{ route('stripe.checkout') }}" style="display: none;">
            @csrf
            <input type="hidden" name="plan_id" id="plan-id-input">
        </form>
    </section>
@endsection

@section('scripts')
    <script>
        const monthlyPlans = @json($monthlyPlans);
        const yearlyPlans = @json($yearlyPlans);
        const isLoggedIn = {{ $userLogin ? 'true' : 'false' }};

        function renderPlans(plans) {
            const container = document.getElementById('plans-container');
            container.innerHTML = '';

            plans.forEach(plan => {
                const html = `
                <div class="col-md-4 p-0">
                    <div class="plan-inner ${plan.name === 'Standard Plan' ? 'orange' : ''}">
                        ${plan.name === 'Standard Plan' ? '<div class="Recommended"><p>Recommended</p></div>' : ''}
                        <h5>${plan.name}</h5>
                        <p>${plan.description || ''}</p>
                        <div class="price">
                            <h3>$${plan.price} <span>/ ${plan.billing_type}</span></h3>
                        </div>
                        <h6>Features of ${plan.name}</h6>
                        <ul>
                            ${(Array.isArray(plan.features) ? plan.features : JSON.parse(plan.features)).map(f => `<li>${f}</li>`).join('')}
                        </ul>
                        <div class="link border">
                            <a href="#" onclick="handleBuyNow('${plan.id}')">Buy Now</a>
                        </div>
                    </div>
                </div>`;
                container.innerHTML += html;
            });
        }

        function handleBuyNow(planId) {
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
            } else {
                document.getElementById('plan-id-input').value = planId;
                document.getElementById('checkout-form').submit();
            }
        }

        // Initial render
        renderPlans(monthlyPlans);

        // Toggle handler
        document.querySelectorAll('input[name="billing"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'monthly') {
                    renderPlans(monthlyPlans);
                } else {
                    renderPlans(yearlyPlans);
                }
            });
        });
    </script>
@endsection
