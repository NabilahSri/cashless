<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
      CRM Dashboard | TailAdmin - Tailwind CSS Admin Dashboard Template
    </title>
    <link rel="icon" href="favicon.ico" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    {{-- <script data-cfasync="false" nonce="db9d0699-c7bd-4290-9e5b-58bcdca54a50">
      try {
        (function (w, d) {
          !(function (j, k, l, m) {
            if (j.zaraz) console.error("zaraz is loaded twice");
            else {
              j[l] = j[l] || {};
              j[l].executed = [];
              j.zaraz = { deferred: [], listeners: [] };
              j.zaraz._v = "5874";
              j.zaraz._n = "db9d0699-c7bd-4290-9e5b-58bcdca54a50";
              j.zaraz.q = [];
              j.zaraz._f = function (n) {
                return async function () {
                  var o = Array.prototype.slice.call(arguments);
                  j.zaraz.q.push({ m: n, a: o });
                };
              };
              for (const p of ["track", "set", "debug"])
                j.zaraz[p] = j.zaraz._f(p);
              j.zaraz.init = () => {
                var q = k.getElementsByTagName(m)[0],
                  r = k.createElement(m),
                  s = k.getElementsByTagName("title")[0];
                s && (j[l].t = k.getElementsByTagName("title")[0].text);
                j[l].x = Math.random();
                j[l].w = j.screen.width;
                j[l].h = j.screen.height;
                j[l].j = j.innerHeight;
                j[l].e = j.innerWidth;
                j[l].l = j.location.href;
                j[l].r = k.referrer;
                j[l].k = j.screen.colorDepth;
                j[l].n = k.characterSet;
                j[l].o = new Date().getTimezoneOffset();
                if (j.dataLayer)
                  for (const t of Object.entries(
                    Object.entries(dataLayer).reduce(
                      (u, v) => ({ ...u[1], ...v[1] }),
                      {}
                    )
                  ))
                    zaraz.set(t[0], t[1], { scope: "page" });
                j[l].q = [];
                for (; j.zaraz.q.length; ) {
                  const w = j.zaraz.q.shift();
                  j[l].q.push(w);
                }
                r.defer = !0;
                for (const x of [localStorage, sessionStorage])
                  Object.keys(x || {})
                    .filter((z) => z.startsWith("_zaraz_"))
                    .forEach((y) => {
                      try {
                        j[l]["z_" + y.slice(7)] = JSON.parse(x.getItem(y));
                      } catch {
                        j[l]["z_" + y.slice(7)] = x.getItem(y);
                      }
                    });
                r.referrerPolicy = "origin";
                r.src =
                  "cdn-cgi/zaraz/sd0d9.js?z=" +
                  btoa(encodeURIComponent(JSON.stringify(j[l])));
                q.parentNode.insertBefore(r, q);
              };
              ["complete", "interactive"].includes(k.readyState)
                ? zaraz.init()
                : j.addEventListener("DOMContentLoaded", zaraz.init);
            }
          })(w, d, "zarazData", "script");
          window.zaraz._p = async (d$) =>
            new Promise((ea) => {
              if (d$) {
                d$.e &&
                  d$.e.forEach((eb) => {
                    try {
                      const ec = d.querySelector("script[nonce]"),
                        ed = ec?.nonce || ec?.getAttribute("nonce"),
                        ee = d.createElement("script");
                      ed && (ee.nonce = ed);
                      ee.innerHTML = eb;
                      ee.onload = () => {
                        d.head.removeChild(ee);
                      };
                      d.head.appendChild(ee);
                    } catch (ef) {
                      console.error(`Error executing script: ${eb}\n`, ef);
                    }
                  });
                Promise.allSettled(
                  (d$.f || []).map((eg) => fetch(eg[0], eg[1]))
                );
              }
              ea();
            });
          zaraz._p({ e: ["(function(w,d){})(window,document)"] });
        })(window, document);
      } catch (e) {
        throw (fetch("/cdn-cgi/zaraz/t"), e);
      }
    </script> --}}
  </head>
  <body
    x-data="{ page: 'crm', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    <div
      x-show="loaded"
      x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
      class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black"
    >
      <div
        class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"
      ></div>
    </div>

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->

      @include('v_layout.sidebar.base-sidebar')

      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div
        class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto"
      >
        <!-- Small Device Overlay Start -->
        <div
          :class="sidebarToggle ? 'block xl:hidden' : 'hidden'"
          class="fixed z-50 h-screen w-full bg-gray-900/50"
        ></div>
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        @include('v_layout.header.base-header')
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div
            class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6"
          >
            <div class="grid grid-cols-12 gap-4 md:gap-6">
              <div class="col-span-12">
                @yield('content')
              </div>
            </div>
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
    <script
      data-cfasync="false"
      src="{{ asset('cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"
    ></script>
    <script defer src="{{ asset('js/bundle.js') }}"></script>
    <script
      defer
      src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
      integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
      data-cf-beacon='{"version":"2024.11.0","token":"67f7a278e3374824ae6dd92295d38f77","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}'
      crossorigin="anonymous"
    ></script>
  </body>

  <!-- Mirrored from demo.tailadmin.com/crm by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Nov 2025 06:20:58 GMT -->
</html>
