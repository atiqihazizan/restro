<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<link rel="icon" href="/img/logo.png" sizes="32x32" />
	<link rel="icon" href="/img/logo.png" sizes="192x192" />
	<link rel="apple-touch-icon" href="/img/logo.png" />
	<title>Restro {{ isset($title) ? '| ' . $title : '' }} </title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="table" content="0">
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<link rel="shortcut icon" href="{{URL::asset('img/logo.png')}}" />

	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ URL::asset('/assets/font-awesome/css/all.css')}}" />

	<!-- MDB -->
	<link rel="stylesheet" href="{{ URL::asset('/css/plugin/compiled.min.css')}}" />
	<link rel="stylesheet" href="{{ URL::asset('/css/plugin/mdb.min.css')}}" />
	<link rel="stylesheet" href="{{ URL::asset('/css/ui-kit/mdb.min.css')}}" />

	<link rel="stylesheet" href="{{ URL::asset('css/counter.css') }}">

</head>

<body class="gray-black">
	<header>
		<nav class="navbar navbar-expand-lg fixed-top navbar-scroll navbar-scrolled gray-black shadow-0 h-topbar py-0">
			<div class="container-fluid">
				<a class="navbar-brand nav-link">
					<h4 class="text-white my-0 me-2 ms-3">{{ $comp->logotxt }}</h4>
				</a>
				<!-- navbar right -->
				<div class="d-flex align-items-center">
					@foreach($nav as $n)
					@continue($n->sts!=1)
					<a class="nav-link nav-link-page nav-counter" href="#{{ $n->id }}"><i class="{{ $n->fa??''}} me-2"></i> {{ $n->name }}</a>
					@endforeach
					<!-- <button type="button" id="itemcart" class="btn btn-danger btn-rounded btn-lg fw-500 text-capitalize d-none"
						data-toggle="sidenav" data-target="#confirm_order"
						class="btn btn-primary" aria-controls="#confirm_order"
						aria-haspopup="true">
						Items in Cart (<span class="count-order">0</span>)
					</button> -->
					<button type="button" id="itemcart" class="btn btn-info btn-rounded btn-lg fw-500 text-capitalize d-none"
						data-target="#confirm_order"
						class="btn btn-primary" aria-controls="#confirm_order"
						aria-haspopup="true">
						Items in Cart (<span class="count-order">0</span>)
					</button>
					<button type="button" id="btn-electron-exit" class="btn btn-outline-light btn-danger btn-rounded btn-lg ms-2 d-none"
						title="Exit" aria-label="Exit application"
						onclick="confirmElectronExit();">
						<i class="fas fa-power-off me-md-1"></i><span class="d-none d-md-inline"></span>
					</button>
				</div>

			</div>
		</nav>
	</header>
	<main style="display: inline-flex;">
		@foreach($nav as $n)
		@continue($n->sts==0)
		<div id="{{ $n->id }}" class="page-frame bg-black d-none animation faster fade-in">@includeIf('counter.' . $n->id)</div>
		@endforeach
	</main>
	
	@stack('modal')

	{{-- Modal boleh dikongsi: padam resit (Sales) dan unlock discount (POS) --}}
	<div class="modal fade top" id="credentialModal" tabindex="-1" aria-labelledby="credentialModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content rounded-9">
				<div class="modal-header border-0 pb-0">
					<h5 class="modal-title fw-bold text-black" id="credentialModalLabel">Confirm password</h5>
					<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pt-3">
					<label class="form-label" for="credentialModalPassword">Password</label>
					<input type="password" class="form-control" id="credentialModalPassword" autocomplete="off">
					<p id="credentialModalError" class="text-danger small mt-2 mb-0 d-none"></p>
				</div>
				<div class="modal-footer border-0 pt-0">
					<button type="button" class="btn btn-secondary rounded-5" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-success rounded-5" id="credentialModalConfirm">Confirm</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="{{URL::asset('/js/plugin/mdb.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('/js/plugin/scripts.bundle.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('/js/plugin/axios.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('/js/plugin/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('/js/mqttws31.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('/js/main.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('/js/mah.js')}}"></script>
	<script>
		const APP_URL = "{{ URL::asset('') }}";
		axios.defaults.headers = {
			'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
		}
		window.RESTRO_CREDENTIAL_VERIFY_URL = {!! json_encode(route('restro.credential.verify')) !!};
		window.RESTRO_CREDENTIAL_SAVE_URL = {!! json_encode(route('restro.credential.save')) !!};

		/** Popup password satu kali akses untuk padam resit atau unlock discount. */
		window.openRestroCredentialModal = (function () {
			var credentialModalEl = document.getElementById('credentialModal');
			var credentialModal = null;
			var credentialSuccessCb = null;

			function getModalInstance() {
				if (!credentialModalEl) return null;
				if (!credentialModal) credentialModal = new mdb.Modal(credentialModalEl, { backdrop: 'static', keyboard: false });
				return credentialModal;
			}

			function wireOnce() {
				if (!credentialModalEl || credentialModalEl.getAttribute('data-cred-modal-wired') === '1') return;
				credentialModalEl.setAttribute('data-cred-modal-wired', '1');
				function credentialModalBlurOn() {
					document.body.classList.add('credential-modal-blur');
				}
				function credentialModalBlurOff() {
					document.body.classList.remove('credential-modal-blur');
				}
				['show.bs.modal', 'show.mdb.modal'].forEach(function (ev) {
					credentialModalEl.addEventListener(ev, credentialModalBlurOn);
				});
				['hidden.bs.modal', 'hidden.mdb.modal'].forEach(function (ev) {
					credentialModalEl.addEventListener(ev, credentialModalBlurOff);
				});
				var pwdInput = document.getElementById('credentialModalPassword');
				var errEl = document.getElementById('credentialModalError');

				document.getElementById('credentialModalConfirm').addEventListener('click', async function () {
					errEl.classList.add('d-none');
					errEl.textContent = '';
					var pw = pwdInput.value;
					if (!pw) {
						errEl.textContent = 'Sila masukkan password.';
						errEl.classList.remove('d-none');
						return;
					}
					try {
						var res = await axios.post(window.RESTRO_CREDENTIAL_VERIFY_URL, { password: pw });
						if (res.data && res.data.success) {
							var cb = credentialSuccessCb;
							credentialSuccessCb = null;
							pwdInput.value = '';
							getModalInstance().hide();
							if (typeof cb === 'function') cb();
						}
					} catch (err) {
						var msg = (err.response && err.response.data && err.response.data.message)
							? err.response.data.message
							: 'Kata laluan tidak sah.';
						errEl.textContent = msg;
						errEl.classList.remove('d-none');
					}
				});
				pwdInput.addEventListener('keydown', function (ev) {
					if (ev.key === 'Enter') {
						ev.preventDefault();
						document.getElementById('credentialModalConfirm').click();
					}
				});
			}

			return function (onSuccess) {
				wireOnce();
				credentialSuccessCb = onSuccess || null;
				var pwdInput = document.getElementById('credentialModalPassword');
				var errEl = document.getElementById('credentialModalError');
				if (pwdInput) pwdInput.value = '';
				if (errEl) {
					errEl.textContent = '';
					errEl.classList.add('d-none');
				}
				getModalInstance().show();
				setTimeout(function () {
					if (pwdInput) pwdInput.focus();
				}, 300);
			};
		})();

		initTabs('.nav-link-page', '.page-frame', function(n) {
			const href = n.getAttribute('href');
			document.querySelectorAll('.sidenav').forEach(function(s) {
				let side = mdb.Sidenav.getInstance(s);
				if (side) side.hide();
			})
			let btnCart = document.getElementById('itemcart');
			if (!btnCart.classList.contains('d-none')) btnCart.classList.add('d-none');
		});


		function pageNav(href) {
			pageChange('#' + href, '.page-frame', '.nav-link-page')
		}
		pageNav('pos')
		
		if (typeof pahoMQTT === 'function') {
			const _mqHub = pahoMQTT();
			if (_mqHub && typeof _mqHub.connect === 'function') _mqHub.connect();
		}

		function confirmElectronExit() {
			if (!window.electronApp || typeof window.electronApp.quit !== 'function') return;
			if (confirm('Are you sure you want to exit?')) {
				window.electronApp.quit();
			}
		}

		(function () {
			var exitBtn = document.getElementById('btn-electron-exit');
			if (exitBtn && window.electronApp && typeof window.electronApp.quit === 'function') {
				exitBtn.classList.remove('d-none');
			}
		})();
	</script>
	@stack('javascript')

</body>

</html>