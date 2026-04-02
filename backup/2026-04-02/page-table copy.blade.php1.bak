<header>
    <nav class="navbar navbar-expand-lg navbar-scroll navbar-scrolled gray-black shadow-0 h-topbar">
        <div class="container-fluid ps-0">
            <a class="navbar-brand nav-link">
                <h4 class="text-white-50 my-0 fs-2x me-2">{{$comp->logotxt}}</h4>
                {{--<h4 class="text-success  my-0 fw-600">RESTRO</h4>--}}
            </a>
            <!-- navbar right -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item"></li>
            </ul>

        </div>
    </nav>
</header>
<div id="desk-container">
    <div class="tables"></div>
</div>

@push('javascript')
<script>
    var mdb_table = function(){
        async function getTable(){
            let res = await axios.get(APP_URL+'ordering/?getdesk=true')
            let data = res.data
            document.querySelector('.tables').innerHTML = data.map((t,n) => {
                // sts = 0: no order 1:pre-order 2:confirm/cooking 3:ready delivery 4:to pay
                // let bgcolor = ['border border-success','bg-success border border-success','bg-danger border border-danger','bg-danger border border-danger'];
                let tm = '';
                if(t.sts > 0) tm = t.odrtm?moment(t.odrtm).format('HH:m'):''
                return `<a href="#page_2" idx="${ t.id }" class="btn btn-block rounded-9 card-btn goto">
                <div class="card border border-success text-capitalize rounded-9">
                    <div class="card-body py-3 text-start">
                        <h5 class="card-title d-flex justify-content-between">
                            <span class="fw-600 fs-3">${ t.name }</span>
                            <!--span class="fs-3">${tm}</span-->
                        </h5>
                        <div class="card-content card-descrip" style="height: calc(100% - 70px)"></div>
                        <!--span class="info fs-5 fw-500">${ t.odrcnt?'Ordered '+t.odrcnt+' items':'No Order' }</span-->
                    </div>
                </div>
            </a>`
            }).join('')
            initTabs('.goto','.page-frame',function(e){
                const idx = e.getAttribute('idx')
                document.querySelector('meta[name="table"]').setAttribute('content',idx)
            })
        }

        // async function subscribe() {
        //     let url = APP_URL + "ordering/paybil"
        //     let sec = 1000
        //     try {
        //         let response = await axios(url);
        //         if (response.status === 200) {
        //             if(response.data === 1) await getTable()
        //             // Reconnect in 10 second
        //             await new Promise(resolve => setTimeout(resolve, sec));
        //             await subscribe();
        //         } else {
        //             // Got message
        //             // let message = await response.text();
        //             console.error(response.statusText)
        //             await new Promise(resolve => setTimeout(resolve, sec));
        //             await subscribe();
        //         }
        //     } catch (err) {
        //         // catches errors both in fetch and response.json
        //         // let's reconnect
        //         console.error('Error throw! ' + err)
        //         await new Promise(resolve => setTimeout(resolve, sec));
        //         await subscribe();
        //     }
        // }
        return {
            init: function(){
                getTable()
            },
            reload: function(res){
                // getTable()
                document.getElementById('pagehome').click()
            }
        }
    }()
    mdb_table.init()
</script>
@endpush
