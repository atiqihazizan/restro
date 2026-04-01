<div class="foods d-flex">
    <div class="sidebar foods-sidebar pt-4">
        <div class="d-flex flex-column">
            <a href="#tabs-item" nav-setting="1" class="food-nav">食品</a>
            <a href="#tabs-cate" nav-setting="2" class="food-nav">类别</a>
            <a href="#tabs-comp" nav-setting="3" class="food-nav">公司名称</a>
        </div>
    </div>
    <div class="foods-container flex-fill">
        <div class="d-none food-page animation faster fade-in" id="tabs-comp">
            <div class="foods-title">
                <h3 class="fw-500 mt-1 mb-0">Company</h3>
            </div>
            <div class="foods-content">
                <div class="card bg-black" style="width: 100%; height: auto">
                    <div class="card-body">
                        <form action="{{ route('company.update',1) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="mb-5">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required value="{{old('name',$comp->name)}}">
                            </div>
                            <div class="mb-5">
                                <label for="name" class="form-label">subtitle</label>
                                <input type="text" class="form-control" name="logotxt" required value="{{old('logotxt',$comp->logotxt)}}">
                            </div>
                            <div class="mb-5">
                                <label for="name" class="form-label">Address</label>
                                <textarea rows="3" class="form-control rounded-5" name="addr" required>{{old('addr',$comp->addr)}}</textarea>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">SST</label>
                                    <input type="text" class="form-control" name="sst" required value="{{old('sst',$comp->sst)}}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-5">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none food-page animation faster fade-in" id="tabs-cate">
            <div class="foods-title">
                <div class="d-flex">
                    <h3 class="fw-500 mt-1 mb-0">Categories</h3>
                    <button class="btn btn-success ms-3 rounded-pill fs-6" add-new-cate><i class="fa fa-plus"></i> Add</button>
                </div>
                <div class="search position-relative">
{{--                    <i class="fa fa-search position-absolute" style="left: 20px; top: 35%"></i>--}}
{{--                    <input type="text" class="form-control-lg rounded-pill ps-5 border-0" placeholder="Search" style="background-color: #26272c">--}}
                </div>
            </div>
            <div class="foods-content">
                <div class="table-responsive">
                    <table class="table table-borderless table-foods">
                        <thead>
                        <tr class="thead-tr fw-500">
                            <td class="text-start">Category Name</td>
                            <td class="text-center" style="width: 140px">Actions</td>
                        </tr>
                        </thead>
                        <tbody id="food-list-cates"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-none food-page animation faster fade-in" id="tabs-item">
                <div class="foods-title">
                    <div class="d-flex">
                        <h3 class="fw-500 mt-1 mb-0">Items</h3>
                        <button class="btn btn-success ms-3 rounded-pill fs-6" add-new-item><i class="fa fa-plus"></i> Add</button>
                    </div>
                    <div class="search position-relative">
{{--                        <i class="fa fa-search position-absolute" style="left: 20px; top: 35%"></i>--}}
{{--                        <input type="text" class="form-control-lg rounded-pill ps-5 border-0" placeholder="Search" style="background-color: #26272c">--}}
                    </div>
                </div>
                <div class="foods-content">
                    <div class="table-responsive">
                        <table class="table table-borderless table-foods">
                            <thead>
                            <tr class="thead-tr fw-500">
                                <td class="text-start">Names</td>
                                <td class="text-start">Category</td>
                                <td class="text-end" style="width: 140px">Amount</td>
                                <td class="text-end" style="width: 10px">Sort</td>
                                <td class="text-center" style="width: 140px">Actions</td>
                            </tr>
                            </thead>
                            <tbody id="food-list-items"></tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>
@push('modal')
<div id="item_form"
     class="sidenav gray-black"
     role="navigation"
     data-scroll-container="#item-container"
     data-width="400"
     data-backdrop-class="bg-gray-white"
     data-content="main"
     data-right="true">

    <div class="item-header_top px-3"></div>
    <div class="item-header sidenav-food sidenav-food-top px-3">
        <h3 class="fw-600 py-4">Food Items</h3>
    </div>
    <div id="item-container" class="sidenav-food sidenav-food-container">
        <form autocomplete="off" >
            <div class="mb-3">
                <label for="name" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="subtext" class="form-label">Other Name</label>
                <input type="text" class="form-control" name="subtext" required>
            </div>
            <div class="mb-3">
                <label for="cate" class="form-label">Categories</label>
                <select class="form-select" name="cate_id" required></select>
            </div>
            <div class="row mb-3">
                <div class="col-md-7">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" required>
                </div>
                <div class="col-md-5">
                    <label for="sort" class="form-label">Sort</label>
                    <input type="number" class="form-control" name="sort">
                </div>
            </div>
        </form>
    </div>
    <div class="item-footer sidenav-food text-center pt-3" style="min-height: 3rem;">
        <div class="d-flex">
            <button class="btn btn-lg py-4 fs-4 btn-success rounded-0 btn-block" data-form-save>Save</button>
            <button class="btn btn-lg py-4 fs-4 btn-danger rounded-0 btn-block" data-form-close>Cancel</button>
        </div>
    </div>
</div>
<div id="cate_form"
     class="sidenav gray-black"
     role="navigation"
     data-scroll-container="#cate-container"
     data-width="400"
     data-content="main"
     data-right="true">

    <div class="cate-header_top px-3"></div>
    <div class="cate-header sidenav-food sidenav-food-top px-3">
        <h3 class="fw-600 py-4">Categories</h3>
    </div>
    <div id="cate-container" class="sidenav-food sidenav-food-container">
        <form autocomplete="off" >
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </form>
    </div>
    <div class="cate-footer sidenav-food text-center pt-3" style="min-height: 3rem;">
        <div class="d-flex">
            <button class="btn btn-lg py-4 fs-4 btn-success rounded-0 btn-block" data-form-save>Save</button>
            <button class="btn btn-lg py-4 fs-4 btn-danger rounded-0 btn-block" data-form-close>Cancel</button>
        </div>
    </div>
</div>
@endpush
@push('javascript')
<script>
    var mdb_foods = function(){
        var foodsPage;
        var cateBarEl;
        var cateBar;
        var cateForm;
        var arCate;
        var itemBarEl;
        var itemBar;
        var itemForm;
        var arItem;
        var oItem = 0;
        var oCate = 0;

        async function initCate(){
            drawCate().then(()=>{
                cateBarEl.querySelector('[data-form-close]').addEventListener('click',function(e){e.preventDefault();cateBar.hide();})
                cateBarEl.querySelector('[data-form-save]').addEventListener('click',function(e){
                    e.preventDefault();
                    let dp = {
                        _token:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        // _method:'put',
                        name: cateForm.elements.name.value,
                    }
                    axios.post(APP_URL+'cate',dp).then(res=> {
                        if(!res.data.success){console.log(res.data);return;}
                        drawCate().then(()=>{cateBar.hide()})
                    }).catch(e=>console.error(e.message))
                })
                cateBarEl.addEventListener('hidden.mdb.sidenav', e => cateForm.reset())
            })
        }
        async function initItem(){
            drawItem().then(()=>{
                itemBarEl.querySelector('[data-form-close]').addEventListener('click',function(e){e.preventDefault();itemBar.hide();})
                itemBarEl.querySelector('[data-form-save]').addEventListener('click',function(e){
                    e.preventDefault()
                    let dp = {
                        _token:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        // _method:'put',
                        name: itemForm.elements.name.value,
                        subtext: itemForm.elements.subtext.value,
                        cate_id: itemForm.elements.cate_id.value,
                        price: itemForm.elements.price.value,
                        sort: itemForm.elements.sort.value,
                    }
                    axios.post(APP_URL+'item',dp).then(res=> {
                        if(!res.data.success){console.error('Add Item Err',res.data);return}
                        drawItem().then(()=>{itemBar.hide()})
                    }).catch(e=>console.error(e.message))
                })
                itemBarEl.addEventListener('hidden.mdb.sidenav', e => itemForm.reset())
            })
        }
        async function drawCate(){
            // busyOn('#items')
            let res = await axios(APP_URL+'cate');
            let cate = res.data??[];
            let tbody = foodsPage.querySelector('#food-list-cates')
            // let select = itemForm.querySelector('[name="cate_id"]')
            // let selectitem = foodsPage.querySelectorAll('.food-category')
            // busyOff()

            oCate = 0;
            // selectitem.forEach(function(e){e.innerHTML = cate.map((f,n)=>{return `<option value="${f.id}">${f.name}</option>`}).join('')})
            // select.innerHTML = cate.map((f,n)=>{return `<option value="${f.id}">${f.name}</option>`}).join('')
            tbody.innerHTML = cate.map((f,n) => {
                let trClass = 'bg-odd';
                if((n % 2) > 0 ) trClass = 'bg-event'
                arCate[f.id] = f
                return `<tr class="${trClass}">
                            <td class="text-start">
                                <input class="free-style" type="text" name="catename" value="${f.name}" >
                            </td>
                            <td class="text-center">
                                <button class="button-table-danger" btn-del-cate idx="${f.id}"><i class="fa fa-trash"></i></button>
                                <button class="button-table-primary" btn-edit-cate idx="${f.id}"><i class="fa fa-pencil-alt"></i></button>
                            </td>
                        </tr>`
            }).join('')
            tbody.querySelectorAll('[btn-del-cate').forEach(function(btn){
                btn.addEventListener('click',function(e){
                    e.preventDefault();
                    oItem = this.getAttribute('idx')
                    let dp = {
                        _token:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        _method:'delete',
                    }
                    axios.delete(APP_URL+'cate/'+oItem,dp).then(res=> {
                        if(!res.data.success){console.log(res.data);return}drawCate()
                    }).catch(e=> {console.error(e.message);})
                })
            })
            tbody.querySelectorAll('[btn-edit-cate').forEach(function(edt){
                edt.addEventListener('click',function(e){
                    let tr = this.closest('tr')
                    let name = tr.querySelector('[name="catename"]').value
                    e.preventDefault();
                    oCate = this.getAttribute('idx')
                    arCate[oCate].name = name
                    let dp = {
                        _token:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        // _method:'put',
                        name: name,
                    }
                    axios.put(APP_URL+'cate/'+oCate,dp).then(res=> {
                        if(!res.data.success){console.log(res.data);return;}drawCate()
                    }).catch(e=> {console.error(e.message);})
                })
            })
        }
        async function drawItem(){
            // busyOn('#items')
            let res1 = await axios(APP_URL+'cate');
            let res = await axios(APP_URL+'item');
            let food = res.data??[];
            let cate = res1.data??[];
            let tbody = foodsPage.querySelector('#food-list-items')
            let select = itemForm.querySelector('[name="cate_id"]')
            let selectitem = foodsPage.querySelectorAll('.food-category')
            // busyOff()

            selectitem.forEach(function(e){e.innerHTML = cate.map((f,n)=>{return `<option value="${f.id}">${f.name}</option>`}).join('')})
            select.innerHTML = cate.map((f,n)=>{return `<option value="${f.id}">${f.name}</option>`}).join('')
            oItem = 0;
            tbody.innerHTML = await food.map((f,n) => {
                let trClass = 'bg-odd';
                let select = cate.map((f1,n)=>{
                    let select = '';
                    if(f.cate_id === f1.id) select = 'selected';
                    return `<option value="${f1.id}" ${select}>${f1.name}</option>`}).join('')

                if((n % 2) > 0 ) trClass = 'bg-event'
                arItem[f.id] = f
                return `<tr class="${trClass}">
                <td class="text-start">
<input class="free-style" type="text" name="itemname" value="${f.name}" >
<br>
<input type="text" class="free-style mt-2" name="subtext" required value="${f.subtext??''}">
</td>
                <td class="text-start"><select class="free-style food-category" name="cateid" value="${f.cate_id}">${select}</select></td>
                <td class="text-end"><input class="free-style text-right" type="text" name="price" value="${f.price}"></td>
                <td class="text-end"><input class="free-style text-right" type="text" name="sort" value="${f.sort}"></td>
                <td class="text-center">
                    <button class="button-table-danger" btn-del-item idx="${f.id}"><i class="fa fa-trash"></i></button>
                    <button class="button-table-primary" btn-edit-item idx="${f.id}"><i class="fa fa-pencil-alt"></i></button>
                </td>
            </tr>`
            }).join('')
            tbody.querySelectorAll('[btn-del-item').forEach(function(btn){
                btn.addEventListener('click',function(e){
                    e.preventDefault();
                    oItem = this.getAttribute('idx')
                    let dp = {
                        _token:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        _method:'delete',
                    }
                    axios.delete(APP_URL+'item/'+oItem,dp).then(res=> {
                        if(!res.data.success){console.log(res.data);return}drawItem()
                    }).catch(e=> {console.error(e.message);})
                })
            })
            tbody.querySelectorAll('[btn-edit-item').forEach(function(edt){
                edt.addEventListener('click',function(e){
                    let tr = this.closest('tr')
                    let name = tr.querySelector('[name="itemname"]').value
                    let subtext = tr.querySelector('[name="subtext"]').value
                    let cate_id = tr.querySelector('[name="cateid"]').value
                    let price = tr.querySelector('[name="price"]').value
                    let sort = tr.querySelector('[name="sort"]').value
                    e.preventDefault();
                    oItem = this.getAttribute('idx')
                    arItem[oItem].name = name
                    arItem[oItem].subtext = subtext
                    arItem[oItem].cate_id = cate_id
                    arItem[oItem].price = price
                    arItem[oItem].sort = sort

                    let dp = {
                        _token:document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        _method:'put',
                        name: name,
                        subtext: subtext,
                        cate_id: cate_id,
                        price: price,
                        sort: sort,
                    }
                    axios.put(APP_URL+'item/'+oItem,dp).then(res=> {
                        if(!res.data.success){console.log(res.data);return}
                        //drawItem()
                    }).catch(e=> {console.error(e.message);})
                })
            })
        }
        return {
            init: async function(){
                foodsPage = document.getElementById('items')
                cateBarEl = document.getElementById('cate_form')
                cateBar = mdb.Sidenav.getInstance(cateBarEl);
                cateForm = cateBarEl.querySelector('form')
                arCate = {}
                itemBarEl = document.getElementById('item_form')
                itemBar = mdb.Sidenav.getInstance(itemBarEl);
                itemForm = itemBarEl.querySelector('form')
                arItem = {}

                initTabs('.food-nav','.food-page',function(e){
                    let nav = e.getAttribute('nav-setting')
                    if(nav == 1) initItem()
                    if(nav == 2) initCate()
                })

                foodsPage.querySelector('[add-new-item]').addEventListener('click',function(e){
                    e.preventDefault()
                    itemForm.elements.name.value = ''
                    itemForm.elements.subtext.value = ''
                    itemForm.elements.cate_id.value = ''
                    itemForm.elements.price.value = '0'
                    itemForm.elements.sort.value = '0'
                    itemBar.show();
                })
                foodsPage.querySelector('[add-new-cate]').addEventListener('click',function(e){
                    e.preventDefault()
                    cateForm.elements.name.value = ''
                    cateBar.show();
                })
            }
        }
    }()
    mdb_foods.init();
</script>
@endpush
