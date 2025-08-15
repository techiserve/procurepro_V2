@extends('stack.layouts.admin')
<style>
  .knob-icon-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
}

.knob-icon {
    width: 40px; /* Adjust size as needed */
    height: 40px;
}
</style>
@section('content')
<div class="content-body">
                <!-- fitness target -->
                <p id="trivia-box">💡 Did you know? Companies lose 5% of revenue to procurement fraud annually.</p>
<script>
    const facts = [
        "🧠 Fun Fact: The word 'procurement' comes from Latin *procurare*, meaning 'to care for'.",
        "💡 Tip: Approving before Friday? Enjoy your weekend guilt-free!",
        "📦 Procurement truth: You don’t need more paperclips. Ever.",
    ];
    setInterval(() => {
        document.getElementById('trivia-box').innerText = facts[Math.floor(Math.random() * facts.length)];
    }, 8000);
</script>


                <div class="row" style="margin-top: 120px;">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row" style="width:100%;">
                                       <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                      <div class="my-1 text-center">
                                          <div class="card-header mb-2 pt-0">
                                              <h5 class="primary">Requisition Requested</h5>
                                              <h3 class="font-large-2 text-bold-200">{{$requisitions}}</h3>
                                          </div>
                                          <div class="card-content position-relative">
                                              <!-- Custom Icon -->
                                              <div class="knob-icon-container">
                                                  <img src="{{ asset('/coreui/img/avatars/layer.png') }}" alt="Icon" class="knob-icon">
                                              </div>
                                              
                                              <!-- Knob Input -->
                                              <input type="text" value="81" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#00B5B8" data-readOnly="true" data-fgColor="#00B5B8">
                                          </div>
                                      </div>
                                  </div>

                                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                      <div class="my-1 text-center">
                                          <div class="card-header mb-2 pt-0">
                                              <h5 class="primary">Pending Requisitions</h5>
                                              <h3 class="font-large-2 text-bold-200">{{$departments}}</h3>
                                          </div>
                                          <div class="card-content position-relative">
                                              <!-- Custom Icon -->
                                              <div class="knob-icon-container">
                                                  <img src="{{ asset('/coreui/img/avatars/notepad.png') }}" alt="Icon" class="knob-icon">
                                              </div>
                                              
                                              <!-- Knob Input -->
                                              <input type="text" value="70" class="knob hide-value responsive angle-offset" data-angleOffset="0" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#00B5B8">
                                          </div>
                                      </div>
                                  </div>

                                    <div class="col-xl-3 col-lg-6 col-md-12 border-right-blue-grey border-right-lighten-5">
                                      <div class="my-1 text-center">
                                          <div class="card-header mb-2 pt-0">
                                              <h5 class="warning">Purchase Orders</h5>
                                              <h3 class="font-large-2 text-bold-200">{{$purchaseorders}}</h3>
                                          </div>
                                          <div class="card-content position-relative">
                                              <!-- Custom Icon -->
                                              <div class="knob-icon-container">
                                                  <img src="{{ asset('/coreui/img/avatars/tick.png') }}" alt="Icon" class="knob-icon">
                                              </div>
                                              
                                              <!-- Knob Input -->
                                              <input type="text" value="81" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#FFA87D">
                                          </div>
                                      </div>
                                  </div>

                                    
                                    <div class="col-xl-3 col-lg-6 col-md-12">
                                        <div class="my-1 text-center">
                                            <div class="card-header mb-2 pt-0">
                                                <h5 class="warning">Pending Purchase Orders</h5>
                                                <h3 class="font-large-2 text-bold-200">{{$userCount}} <span class="font-medium-1 grey darken-1 text-bold-400"></span></h3>
                                            </div>
                                            <div class="card-content position-relative">

                                            <div class="knob-icon-container">
                                                  <img src="{{ asset('/coreui/img/avatars/time.png') }}" alt="Icon" class="knob-icon">
                                              </div>
                                              

                                                <input type="text" value="75" class="knob hide-value responsive angle-offset" data-angleOffset="20" data-thickness=".15" data-linecap="round" data-width="130" data-height="130" data-inputColor="#BABFC7" data-readOnly="true" data-fgColor="#FFA87D" >
                                            
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
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>


<script>
    function celebrate() {
        setTimeout(function() {
            confetti({
                particleCount: 200,
                spread: 100,
                origin: { y: 0.6 }
            });
        }, 2000); // Delay in milliseconds (2000ms = 2 seconds)
    }
</script>
