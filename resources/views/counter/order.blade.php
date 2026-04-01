<div style="background-color: #393939">
    @include('ordering.partials.orderlay')
</div>
@push('javascript')
    <script>
        var mdb_order = function(){

            return {
                init: function(){
                    // document.getElementById('back-to-table').setAttribute('href','#pos')
                }
            }
        }()
        mdb_order.init()
    </script>
@endpush
