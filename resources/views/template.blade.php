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

      @include('v_layout.sidebar.sidebar')

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
        <header
          x-data="{menuToggle: false}"
          class="sticky top-0 z-99999 flex w-full border-gray-200 bg-white xl:border-b dark:border-gray-800 dark:bg-gray-900"
        >
          <div
            class="flex grow flex-col items-center justify-between xl:flex-row xl:px-6"
          >
            <div
              class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 sm:gap-4 lg:py-4 xl:justify-normal xl:border-b-0 xl:px-0 dark:border-gray-800"
            >
              <!-- Hamburger Toggle BTN -->
              <button
                :class="sidebarToggle ? 'xl:bg-transparent dark:xl:bg-transparent bg-gray-100 dark:bg-gray-800' : ''"
                class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg border-gray-200 text-gray-500 xl:h-11 xl:w-11 xl:border dark:border-gray-800 dark:text-gray-400"
                @click.stop="sidebarToggle = !sidebarToggle"
              >
                <svg
                  class="hidden fill-current xl:block"
                  width="16"
                  height="12"
                  viewBox="0 0 16 12"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
                    fill=""
                  />
                </svg>

                <svg
                  :class="sidebarToggle ? 'hidden' : 'block xl:hidden'"
                  class="fill-current xl:hidden"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"
                    fill=""
                  />
                </svg>

                <!-- cross icon -->
                <svg
                  :class="sidebarToggle ? 'block xl:hidden' : 'hidden'"
                  class="fill-current"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
                    fill=""
                  />
                </svg>
              </button>
              <!-- Hamburger Toggle BTN -->

              <a href="index-2.html" class="xl:hidden">
                <img
                  class="dark:hidden"
                  src="src/images/logo/logo.svg"
                  alt="Logo"
                />
                <img
                  class="hidden dark:block"
                  src="src/images/logo/logo-dark.svg"
                  alt="Logo"
                />
              </a>

              <!-- Application nav menu button -->
              <button
                class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 xl:hidden dark:text-gray-400 dark:hover:bg-gray-800"
                :class="menuToggle ? 'bg-gray-100 dark:bg-gray-800' : ''"
                @click.stop="menuToggle = !menuToggle"
              >
                <svg
                  class="fill-current"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M5.99902 10.4951C6.82745 10.4951 7.49902 11.1667 7.49902 11.9951V12.0051C7.49902 12.8335 6.82745 13.5051 5.99902 13.5051C5.1706 13.5051 4.49902 12.8335 4.49902 12.0051V11.9951C4.49902 11.1667 5.1706 10.4951 5.99902 10.4951ZM17.999 10.4951C18.8275 10.4951 19.499 11.1667 19.499 11.9951V12.0051C19.499 12.8335 18.8275 13.5051 17.999 13.5051C17.1706 13.5051 16.499 12.8335 16.499 12.0051V11.9951C16.499 11.1667 17.1706 10.4951 17.999 10.4951ZM13.499 11.9951C13.499 11.1667 12.8275 10.4951 11.999 10.4951C11.1706 10.4951 10.499 11.1667 10.499 11.9951V12.0051C10.499 12.8335 11.1706 13.5051 11.999 13.5051C12.8275 13.5051 13.499 12.8335 13.499 12.0051V11.9951Z"
                    fill=""
                  />
                </svg>
              </button>
              <!-- Application nav menu button -->

              <div class="hidden xl:block">
                <form>
                  <div class="relative">
                    <span
                      class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2"
                    >
                      <svg
                        class="fill-gray-500 dark:fill-gray-400"
                        width="20"
                        height="20"
                        viewBox="0 0 20 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                          fill=""
                        />
                      </svg>
                    </span>
                    <input
                      id="search-input"
                      type="text"
                      placeholder="Search or type command..."
                      class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-14 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[430px] dark:border-gray-800 dark:bg-gray-900 dark:bg-white/[0.03] dark:text-white/90 dark:placeholder:text-white/30"
                    />

                    <button
                      id="search-button"
                      class="absolute top-1/2 right-2.5 inline-flex -translate-y-1/2 items-center gap-0.5 rounded-lg border border-gray-200 bg-gray-50 px-[7px] py-[4.5px] text-xs -tracking-[0.2px] text-gray-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400"
                    >
                      <span> ⌘ </span>
                      <span> K </span>
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <div
              :class="menuToggle ? 'flex' : 'hidden'"
              class="shadow-theme-md w-full items-center justify-between gap-4 px-5 py-4 xl:flex xl:justify-end xl:px-0 xl:shadow-none"
            >
              <div class="2xsm:gap-3 flex items-center gap-2">
                <!-- Dark Mode Toggler -->
                <button
                  class="hover:text-dark-900 relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                  @click.prevent="darkMode = !darkMode"
                >
                  <svg
                    class="hidden dark:block"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001ZM15.9813 5.08035C16.2742 4.78746 16.2742 4.31258 15.9813 4.01969C15.6884 3.7268 15.2135 3.7268 14.9207 4.01969L14.0368 4.90357C13.7439 5.19647 13.7439 5.67134 14.0368 5.96423C14.3297 6.25713 14.8045 6.25713 15.0974 5.96423L15.9813 5.08035ZM18.4577 10.0001C18.4577 10.4143 18.1219 10.7501 17.7077 10.7501H16.4577C16.0435 10.7501 15.7077 10.4143 15.7077 10.0001C15.7077 9.58592 16.0435 9.25013 16.4577 9.25013H17.7077C18.1219 9.25013 18.4577 9.58592 18.4577 10.0001ZM14.9207 15.9806C15.2135 16.2735 15.6884 16.2735 15.9813 15.9806C16.2742 15.6877 16.2742 15.2128 15.9813 14.9199L15.0974 14.036C14.8045 13.7431 14.3297 13.7431 14.0368 14.036C13.7439 14.3289 13.7439 14.8038 14.0368 15.0967L14.9207 15.9806ZM9.99998 15.7088C10.4142 15.7088 10.75 16.0445 10.75 16.4588V17.7088C10.75 18.123 10.4142 18.4588 9.99998 18.4588C9.58577 18.4588 9.24998 18.123 9.24998 17.7088V16.4588C9.24998 16.0445 9.58577 15.7088 9.99998 15.7088ZM5.96356 15.0972C6.25646 14.8043 6.25646 14.3295 5.96356 14.0366C5.67067 13.7437 5.1958 13.7437 4.9029 14.0366L4.01902 14.9204C3.72613 15.2133 3.72613 15.6882 4.01902 15.9811C4.31191 16.274 4.78679 16.274 5.07968 15.9811L5.96356 15.0972ZM4.29224 10.0001C4.29224 10.4143 3.95645 10.7501 3.54224 10.7501H2.29224C1.87802 10.7501 1.54224 10.4143 1.54224 10.0001C1.54224 9.58592 1.87802 9.25013 2.29224 9.25013H3.54224C3.95645 9.25013 4.29224 9.58592 4.29224 10.0001ZM4.9029 5.9637C5.1958 6.25659 5.67067 6.25659 5.96356 5.9637C6.25646 5.6708 6.25646 5.19593 5.96356 4.90303L5.07968 4.01915C4.78679 3.72626 4.31191 3.72626 4.01902 4.01915C3.72613 4.31204 3.72613 4.78692 4.01902 5.07981L4.9029 5.9637Z"
                      fill="currentColor"
                    />
                  </svg>
                  <svg
                    class="dark:hidden"
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8401 11.3266C17.5538 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.44682 8.67398 2.16046C8.50243 1.8741 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z"
                      fill="currentColor"
                    />
                  </svg>
                </button>
                <!-- Dark Mode Toggler -->

                <!-- Notification Menu Area -->
                <div
                  class="relative"
                  x-data="{ dropdownOpen: false, notifying: true }"
                  @click.outside="dropdownOpen = false"
                >
                  <button
                    class="hover:text-dark-900 relative flex h-11 w-11 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                    @click.prevent="dropdownOpen = ! dropdownOpen; notifying = false"
                  >
                    <span
                      :class="!notifying ? 'hidden' : 'flex'"
                      class="absolute top-0.5 right-0 z-1 h-2 w-2 rounded-full bg-orange-400"
                    >
                      <span
                        class="absolute -z-1 inline-flex h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"
                      ></span>
                    </span>
                    <svg
                      class="fill-current"
                      width="20"
                      height="20"
                      viewBox="0 0 20 20"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z"
                        fill=""
                      />
                    </svg>
                  </button>

                  <!-- Dropdown Start -->
                  <div
                    x-show="dropdownOpen"
                    class="shadow-theme-lg dark:bg-gray-dark absolute -right-[240px] mt-[17px] flex h-[480px] w-[350px] flex-col rounded-2xl border border-gray-200 bg-white p-3 sm:w-[361px] lg:right-0 dark:border-gray-800"
                  >
                    <div
                      class="mb-3 flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800"
                    >
                      <h5
                        class="text-lg font-semibold text-gray-800 dark:text-white/90"
                      >
                        Notification
                      </h5>

                      <button
                        @click="dropdownOpen = false"
                        class="text-gray-500 dark:text-gray-400"
                      >
                        <svg
                          class="fill-current"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
                            fill=""
                          />
                        </svg>
                      </button>
                    </div>

                    <ul
                      class="custom-scrollbar flex h-auto flex-col overflow-y-auto"
                    >
                      <li>
                        <a
                          class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                          href="#"
                        >
                          <span
                            class="relative z-1 block h-10 w-full max-w-10 rounded-full"
                          >
                            <img
                              src="src/images/user/user-02.jpg"
                              alt="User"
                              class="overflow-hidden rounded-full"
                            />
                            <span
                              class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
                            ></span>
                          </span>

                          <span class="block">
                            <span
                              class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
                            >
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Terry Franci</span
                              >
                              requests permission to change
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Project - Nganter App</span
                              >
                            </span>

                            <span
                              class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
                            >
                              <span>Project</span>
                              <span
                                class="h-1 w-1 rounded-full bg-gray-400"
                              ></span>
                              <span>5 min ago</span>
                            </span>
                          </span>
                        </a>
                      </li>

                      <li>
                        <a
                          class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                          href="#"
                        >
                          <span
                            class="relative z-1 block h-10 w-full max-w-10 rounded-full"
                          >
                            <img
                              src="src/images/user/user-03.jpg"
                              alt="User"
                              class="overflow-hidden rounded-full"
                            />
                            <span
                              class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
                            ></span>
                          </span>

                          <span class="block">
                            <span
                              class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
                            >
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Alena Franci</span
                              >
                              requests permission to change
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Project - Nganter App</span
                              >
                            </span>

                            <span
                              class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
                            >
                              <span>Project</span>
                              <span
                                class="h-1 w-1 rounded-full bg-gray-400"
                              ></span>
                              <span>8 min ago</span>
                            </span>
                          </span>
                        </a>
                      </li>

                      <li>
                        <a
                          class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                          href="#"
                        >
                          <span
                            class="relative z-1 block h-10 w-full max-w-10 rounded-full"
                          >
                            <img
                              src="src/images/user/user-04.jpg"
                              alt="User"
                              class="overflow-hidden rounded-full"
                            />
                            <span
                              class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
                            ></span>
                          </span>

                          <span class="block">
                            <span
                              class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
                            >
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Jocelyn Kenter</span
                              >
                              requests permission to change
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Project - Nganter App</span
                              >
                            </span>

                            <span
                              class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
                            >
                              <span>Project</span>
                              <span
                                class="h-1 w-1 rounded-full bg-gray-400"
                              ></span>
                              <span>15 min ago</span>
                            </span>
                          </span>
                        </a>
                      </li>

                      <li>
                        <a
                          class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                          href="#"
                        >
                          <span
                            class="relative z-1 block h-10 w-full max-w-10 rounded-full"
                          >
                            <img
                              src="src/images/user/user-05.jpg"
                              alt="User"
                              class="overflow-hidden rounded-full"
                            />
                            <span
                              class="bg-error-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
                            ></span>
                          </span>

                          <span class="block">
                            <span
                              class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
                            >
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Brandon Philips</span
                              >
                              requests permission to change
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Project - Nganter App</span
                              >
                            </span>

                            <span
                              class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
                            >
                              <span>Project</span>
                              <span
                                class="h-1 w-1 rounded-full bg-gray-400"
                              ></span>
                              <span>1 hr ago</span>
                            </span>
                          </span>
                        </a>
                      </li>

                      <li>
                        <a
                          class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                          href="#"
                        >
                          <span
                            class="relative z-1 block h-10 w-full max-w-10 rounded-full"
                          >
                            <img
                              src="src/images/user/user-02.jpg"
                              alt="User"
                              class="overflow-hidden rounded-full"
                            />
                            <span
                              class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
                            ></span>
                          </span>

                          <span class="block">
                            <span
                              class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
                            >
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Terry Franci</span
                              >
                              requests permission to change
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Project - Nganter App</span
                              >
                            </span>

                            <span
                              class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
                            >
                              <span>Project</span>
                              <span
                                class="h-1 w-1 rounded-full bg-gray-400"
                              ></span>
                              <span>5 min ago</span>
                            </span>
                          </span>
                        </a>
                      </li>

                      <li>
                        <a
                          class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                          href="#"
                        >
                          <span
                            class="relative z-1 block h-10 w-full max-w-10 rounded-full"
                          >
                            <img
                              src="src/images/user/user-03.jpg"
                              alt="User"
                              class="overflow-hidden rounded-full"
                            />
                            <span
                              class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
                            ></span>
                          </span>

                          <span class="block">
                            <span
                              class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
                            >
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Alena Franci</span
                              >
                              requests permission to change
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Project - Nganter App</span
                              >
                            </span>

                            <span
                              class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
                            >
                              <span>Project</span>
                              <span
                                class="h-1 w-1 rounded-full bg-gray-400"
                              ></span>
                              <span>8 min ago</span>
                            </span>
                          </span>
                        </a>
                      </li>

                      <li>
                        <a
                          class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                          href="#"
                        >
                          <span
                            class="relative z-1 block h-10 w-full max-w-10 rounded-full"
                          >
                            <img
                              src="src/images/user/user-04.jpg"
                              alt="User"
                              class="overflow-hidden rounded-full"
                            />
                            <span
                              class="bg-success-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
                            ></span>
                          </span>

                          <span class="block">
                            <span
                              class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
                            >
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Jocelyn Kenter</span
                              >
                              requests permission to change
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Project - Nganter App</span
                              >
                            </span>

                            <span
                              class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
                            >
                              <span>Project</span>
                              <span
                                class="h-1 w-1 rounded-full bg-gray-400"
                              ></span>
                              <span>15 min ago</span>
                            </span>
                          </span>
                        </a>
                      </li>

                      <li>
                        <a
                          class="flex gap-3 rounded-lg border-b border-gray-100 p-3 px-4.5 py-3 hover:bg-gray-100 dark:border-gray-800 dark:hover:bg-white/5"
                          href="#"
                        >
                          <span
                            class="relative z-1 block h-10 w-full max-w-10 rounded-full"
                          >
                            <img
                              src="src/images/user/user-05.jpg"
                              alt="User"
                              class="overflow-hidden rounded-full"
                            />
                            <span
                              class="bg-error-500 absolute right-0 bottom-0 z-10 h-2.5 w-full max-w-2.5 rounded-full border-[1.5px] border-white dark:border-gray-900"
                            ></span>
                          </span>

                          <span class="block">
                            <span
                              class="text-theme-sm mb-1.5 block text-gray-500 dark:text-gray-400"
                            >
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Brandon Philips</span
                              >
                              requests permission to change
                              <span
                                class="font-medium text-gray-800 dark:text-white/90"
                                >Project - Nganter App</span
                              >
                            </span>

                            <span
                              class="text-theme-xs flex items-center gap-2 text-gray-500 dark:text-gray-400"
                            >
                              <span>Project</span>
                              <span
                                class="h-1 w-1 rounded-full bg-gray-400"
                              ></span>
                              <span>1 hr ago</span>
                            </span>
                          </span>
                        </a>
                      </li>
                    </ul>

                    <a
                      href="#"
                      class="text-theme-sm shadow-theme-xs mt-3 flex justify-center rounded-lg border border-gray-300 bg-white p-3 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                    >
                      View All Notification
                    </a>
                  </div>
                  <!-- Dropdown End -->
                </div>
                <!-- Notification Menu Area -->
              </div>

              <!-- User Area -->
              <div
                class="relative"
                x-data="{ dropdownOpen: false }"
                @click.outside="dropdownOpen = false"
              >
                <a
                  class="flex items-center text-gray-700 dark:text-gray-400"
                  href="#"
                  @click.prevent="dropdownOpen = ! dropdownOpen"
                >
                  <span class="mr-3 h-11 w-11 overflow-hidden rounded-full">
                    <img src="src/images/user/owner.png" alt="User" />
                  </span>

                  <span class="text-theme-sm mr-1 block font-medium">
                    Musharof
                  </span>

                  <svg
                    :class="dropdownOpen && 'rotate-180'"
                    class="stroke-gray-500 dark:stroke-gray-400"
                    width="18"
                    height="20"
                    viewBox="0 0 18 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M4.3125 8.65625L9 13.3437L13.6875 8.65625"
                      stroke=""
                      stroke-width="1.5"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                </a>

                <!-- Dropdown Start -->
                <div
                  x-show="dropdownOpen"
                  class="shadow-theme-lg dark:bg-gray-dark absolute right-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 dark:border-gray-800"
                >
                  <div>
                    <span
                      class="text-theme-sm block font-medium text-gray-700 dark:text-gray-400"
                    >
                      Musharof Chowdhury
                    </span>
                    <span
                      class="text-theme-xs mt-0.5 block text-gray-500 dark:text-gray-400"
                    >
                      <a
                        href="cdn-cgi/l/email-protection.html"
                        class="__cf_email__"
                        data-cfemail="3547545b515a584046504775455c585f5a1b565a58"
                        >[email&#160;protected]</a
                      >
                    </span>
                  </div>

                  <ul
                    class="flex flex-col gap-1 border-b border-gray-200 pt-4 pb-3 dark:border-gray-800"
                  >
                    <li>
                      <a
                        href="profile.html"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                      >
                        <svg
                          class="fill-gray-500 group-hover:fill-gray-700 dark:fill-gray-400 dark:group-hover:fill-gray-300"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z"
                            fill=""
                          />
                        </svg>
                        Edit profile
                      </a>
                    </li>
                    <li>
                      <a
                        href="chat.html"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                      >
                        <svg
                          class="fill-gray-500 group-hover:fill-gray-700 dark:fill-gray-400 dark:group-hover:fill-gray-300"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M10.4858 3.5L13.5182 3.5C13.9233 3.5 14.2518 3.82851 14.2518 4.23377C14.2518 5.9529 16.1129 7.02795 17.602 6.1682C17.9528 5.96567 18.4014 6.08586 18.6039 6.43667L20.1203 9.0631C20.3229 9.41407 20.2027 9.86286 19.8517 10.0655C18.3625 10.9253 18.3625 13.0747 19.8517 13.9345C20.2026 14.1372 20.3229 14.5859 20.1203 14.9369L18.6039 17.5634C18.4013 17.9142 17.9528 18.0344 17.602 17.8318C16.1129 16.9721 14.2518 18.0471 14.2518 19.7663C14.2518 20.1715 13.9233 20.5 13.5182 20.5H10.4858C10.0804 20.5 9.75182 20.1714 9.75182 19.766C9.75182 18.0461 7.88983 16.9717 6.40067 17.8314C6.04945 18.0342 5.60037 17.9139 5.39767 17.5628L3.88167 14.937C3.67903 14.586 3.79928 14.1372 4.15026 13.9346C5.63949 13.0748 5.63946 10.9253 4.15025 10.0655C3.79926 9.86282 3.67901 9.41401 3.88165 9.06303L5.39764 6.43725C5.60034 6.08617 6.04943 5.96581 6.40065 6.16858C7.88982 7.02836 9.75182 5.9539 9.75182 4.23399C9.75182 3.82862 10.0804 3.5 10.4858 3.5ZM13.5182 2L10.4858 2C9.25201 2 8.25182 3.00019 8.25182 4.23399C8.25182 4.79884 7.64013 5.15215 7.15065 4.86955C6.08213 4.25263 4.71559 4.61859 4.0986 5.68725L2.58261 8.31303C1.96575 9.38146 2.33183 10.7477 3.40025 11.3645C3.88948 11.647 3.88947 12.3531 3.40026 12.6355C2.33184 13.2524 1.96578 14.6186 2.58263 15.687L4.09863 18.3128C4.71562 19.3814 6.08215 19.7474 7.15067 19.1305C7.64015 18.8479 8.25182 19.2012 8.25182 19.766C8.25182 20.9998 9.25201 22 10.4858 22H13.5182C14.7519 22 15.7518 20.9998 15.7518 19.7663C15.7518 19.2015 16.3632 18.8487 16.852 19.1309C17.9202 19.7476 19.2862 19.3816 19.9029 18.3134L21.4193 15.6869C22.0361 14.6185 21.6701 13.2523 20.6017 12.6355C20.1125 12.3531 20.1125 11.647 20.6017 11.3645C21.6701 10.7477 22.0362 9.38152 21.4193 8.3131L19.903 5.68667C19.2862 4.61842 17.9202 4.25241 16.852 4.86917C16.3632 5.15138 15.7518 4.79856 15.7518 4.23377C15.7518 3.00024 14.7519 2 13.5182 2ZM9.6659 11.9999C9.6659 10.7103 10.7113 9.66493 12.0009 9.66493C13.2905 9.66493 14.3359 10.7103 14.3359 11.9999C14.3359 13.2895 13.2905 14.3349 12.0009 14.3349C10.7113 14.3349 9.6659 13.2895 9.6659 11.9999ZM12.0009 8.16493C9.88289 8.16493 8.1659 9.88191 8.1659 11.9999C8.1659 14.1179 9.88289 15.8349 12.0009 15.8349C14.1189 15.8349 15.8359 14.1179 15.8359 11.9999C15.8359 9.88191 14.1189 8.16493 12.0009 8.16493Z"
                            fill=""
                          />
                        </svg>
                        Account settings
                      </a>
                    </li>
                    <li>
                      <a
                        href="profile.html"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                      >
                        <svg
                          class="fill-gray-500 group-hover:fill-gray-700 dark:fill-gray-400 dark:group-hover:fill-gray-300"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M3.5 12C3.5 7.30558 7.30558 3.5 12 3.5C16.6944 3.5 20.5 7.30558 20.5 12C20.5 16.6944 16.6944 20.5 12 20.5C7.30558 20.5 3.5 16.6944 3.5 12ZM12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM11.0991 7.52507C11.0991 8.02213 11.5021 8.42507 11.9991 8.42507H12.0001C12.4972 8.42507 12.9001 8.02213 12.9001 7.52507C12.9001 7.02802 12.4972 6.62507 12.0001 6.62507H11.9991C11.5021 6.62507 11.0991 7.02802 11.0991 7.52507ZM12.0001 17.3714C11.5859 17.3714 11.2501 17.0356 11.2501 16.6214V10.9449C11.2501 10.5307 11.5859 10.1949 12.0001 10.1949C12.4143 10.1949 12.7501 10.5307 12.7501 10.9449V16.6214C12.7501 17.0356 12.4143 17.3714 12.0001 17.3714Z"
                            fill=""
                          />
                        </svg>
                        Support
                      </a>
                    </li>
                  </ul>
                  <button
                    class="group text-theme-sm mt-3 flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                  >
                    <svg
                      class="fill-gray-500 group-hover:fill-gray-700 dark:group-hover:fill-gray-300"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M15.1007 19.247C14.6865 19.247 14.3507 18.9112 14.3507 18.497L14.3507 14.245H12.8507V18.497C12.8507 19.7396 13.8581 20.747 15.1007 20.747H18.5007C19.7434 20.747 20.7507 19.7396 20.7507 18.497L20.7507 5.49609C20.7507 4.25345 19.7433 3.24609 18.5007 3.24609H15.1007C13.8581 3.24609 12.8507 4.25345 12.8507 5.49609V9.74501L14.3507 9.74501V5.49609C14.3507 5.08188 14.6865 4.74609 15.1007 4.74609L18.5007 4.74609C18.9149 4.74609 19.2507 5.08188 19.2507 5.49609L19.2507 18.497C19.2507 18.9112 18.9149 19.247 18.5007 19.247H15.1007ZM3.25073 11.9984C3.25073 12.2144 3.34204 12.4091 3.48817 12.546L8.09483 17.1556C8.38763 17.4485 8.86251 17.4487 9.15549 17.1559C9.44848 16.8631 9.44863 16.3882 9.15583 16.0952L5.81116 12.7484L16.0007 12.7484C16.4149 12.7484 16.7507 12.4127 16.7507 11.9984C16.7507 11.5842 16.4149 11.2484 16.0007 11.2484L5.81528 11.2484L9.15585 7.90554C9.44864 7.61255 9.44847 7.13767 9.15547 6.84488C8.86248 6.55209 8.3876 6.55226 8.09481 6.84525L3.52309 11.4202C3.35673 11.5577 3.25073 11.7657 3.25073 11.9984Z"
                        fill=""
                      />
                    </svg>

                    Sign out
                  </button>
                </div>
                <!-- Dropdown End -->
              </div>
              <!-- User Area -->
            </div>
          </div>
        </header>
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div
            class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6"
          >
            <div class="grid grid-cols-12 gap-4 md:gap-6">
              <div class="col-span-12">
                <!-- Metric Group Four -->
                <div
                  class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-3"
                >
                  <!-- Metric Item Start -->
                  <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
                  >
                    <h4
                      class="text-title-sm font-bold text-gray-800 dark:text-white/90"
                    >
                      $120,369
                    </h4>

                    <div class="mt-4 flex items-end justify-between sm:mt-5">
                      <div>
                        <p
                          class="text-theme-sm text-gray-700 dark:text-gray-400"
                        >
                          Active Deal
                        </p>
                      </div>

                      <div class="flex items-center gap-1">
                        <span
                          class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500"
                        >
                          +20%
                        </span>

                        <span
                          class="text-theme-xs text-gray-500 dark:text-gray-400"
                        >
                          From last month
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- Metric Item End -->

                  <!-- Metric Item Start -->
                  <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
                  >
                    <h4
                      class="text-title-sm font-bold text-gray-800 dark:text-white/90"
                    >
                      $234,210
                    </h4>

                    <div class="mt-4 flex items-end justify-between sm:mt-5">
                      <div>
                        <p
                          class="text-theme-sm text-gray-700 dark:text-gray-400"
                        >
                          Revenue Total
                        </p>
                      </div>

                      <div class="flex items-center gap-1">
                        <span
                          class="flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500"
                        >
                          +9.0%
                        </span>

                        <span
                          class="text-theme-xs text-gray-500 dark:text-gray-400"
                        >
                          From last month
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- Metric Item End -->

                  <!-- Metric Item Start -->
                  <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6"
                  >
                    <h4
                      class="text-title-sm font-bold text-gray-800 dark:text-white/90"
                    >
                      874
                    </h4>

                    <div class="mt-4 flex items-end justify-between sm:mt-5">
                      <div>
                        <p
                          class="text-theme-sm text-gray-700 dark:text-gray-400"
                        >
                          Closed Deals
                        </p>
                      </div>

                      <div class="flex items-center gap-1">
                        <span
                          class="flex items-center gap-1 rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500"
                        >
                          -4.5%
                        </span>

                        <span
                          class="text-theme-xs text-gray-500 dark:text-gray-400"
                        >
                          From last month
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- Metric Item End -->
                </div>
                <!-- Metric Group Four -->
              </div>

              <div class="col-span-12 xl:col-span-8">
                <!-- ====== Chart Eleven Start -->
                <div
                  class="rounded-2xl border border-gray-200 bg-white px-5 pb-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6"
                >
                  <div
                    class="flex flex-col gap-5 mb-6 sm:flex-row sm:items-center sm:justify-between"
                  >
                    <div>
                      <h3
                        class="text-lg font-semibold text-gray-800 dark:text-white/90"
                      >
                        Statistics
                      </h3>
                      <p
                        class="mt-1 text-gray-500 text-theme-sm dark:text-gray-400"
                      >
                        Target you’ve set for each month
                      </p>
                    </div>

                    <div
                      x-data="{selected: 'optionOne'}"
                      class="inline-flex items-center gap-0.5 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900"
                    >
                      <button
                        @click="selected = 'optionOne'"
                        :class="selected === 'optionOne' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'"
                        class="px-3 py-2 font-medium rounded-md text-theme-sm hover:text-gray-900 hover:shadow-theme-xs dark:hover:bg-gray-800 dark:hover:text-white"
                      >
                        Monthly
                      </button>

                      <button
                        @click="selected = 'optionTwo'"
                        :class="selected === 'optionTwo' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'"
                        class="px-3 py-2 font-medium rounded-md text-theme-sm hover:text-gray-900 hover:shadow-theme-xs dark:hover:text-white"
                      >
                        Quarterly
                      </button>

                      <button
                        @click="selected = 'optionThree'"
                        :class="selected === 'optionThree' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-800' : 'text-gray-500 dark:text-gray-400'"
                        class="px-3 py-2 font-medium rounded-md text-theme-sm hover:text-gray-900 hover:shadow-theme-xs dark:hover:text-white"
                      >
                        Annually
                      </button>
                    </div>
                  </div>

                  <div class="flex gap-4 sm:gap-9">
                    <div class="flex items-start gap-2">
                      <div>
                        <h4
                          class="mb-0.5 text-base font-bold text-gray-800 dark:text-white/90 sm:text-theme-xl"
                        >
                          $212,142.12
                        </h4>
                        <span
                          class="text-gray-500 text-theme-xs dark:text-gray-400"
                        >
                          Avg. Yearly Profit
                        </span>
                      </div>

                      <span
                        class="mt-1.5 flex items-center gap-1 rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500"
                      >
                        +23.2%
                      </span>
                    </div>

                    <div class="flex items-start gap-2">
                      <div>
                        <h4
                          class="mb-0.5 text-base font-bold text-gray-800 dark:text-white/90 sm:text-theme-xl"
                        >
                          $30,321.23
                        </h4>
                        <span
                          class="text-gray-500 text-theme-xs dark:text-gray-400"
                        >
                          Avg. Yearly Profit
                        </span>
                      </div>

                      <span
                        class="mt-1.5 flex items-center gap-1 rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500"
                      >
                        -12.3%
                      </span>
                    </div>
                  </div>
                  <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <div
                      id="chartEleven"
                      class="-ml-4 min-w-[1000px] pl-2 xl:min-w-full"
                    ></div>
                  </div>
                </div>
                <!-- ====== Chart Eleven End -->
              </div>

              <div class="col-span-12 xl:col-span-4">
                <!-- ====== Chart Twelve Start -->
                <div
                  class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6"
                >
                  <div class="flex justify-between">
                    <div>
                      <h3
                        class="text-lg font-semibold text-gray-800 dark:text-white/90"
                      >
                        Estimated Revenue
                      </h3>
                      <p
                        class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400"
                      >
                        Target you’ve set for each month
                      </p>
                    </div>

                    <div x-data="{openDropDown: false}" class="relative h-fit">
                      <button
                        @click="openDropDown = !openDropDown"
                        :class="openDropDown ? 'text-gray-700 dark:text-white' : 'text-gray-400 hover:text-gray-700 dark:hover:text-white'"
                      >
                        <svg
                          class="fill-current"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                            fill=""
                          />
                        </svg>
                      </button>
                      <div
                        x-show="openDropDown"
                        @click.outside="openDropDown = false"
                        class="absolute right-0 top-full z-40 w-40 space-y-1 rounded-2xl border border-gray-200 bg-white p-2 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark"
                      >
                        <button
                          class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                        >
                          View More
                        </button>
                        <button
                          class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                        >
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="relative">
                    <div id="chartTwelve"></div>
                    <span
                      class="absolute left-1/2 top-[60%] -translate-x-1/2 -translate-y-[60%] text-xs font-normal text-gray-500 dark:text-gray-400"
                      >June Goals</span
                    >
                  </div>

                  <div
                    class="border-gary-200 mt-6 space-y-5 border-t pt-6 dark:border-gray-800"
                  >
                    <div>
                      <p
                        class="mb-2 text-theme-sm text-gray-500 dark:text-gray-400"
                      >
                        Marketing
                      </p>
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                          <div>
                            <p
                              class="text-base font-semibold text-gray-800 dark:text-white/90"
                            >
                              $30,569.00
                            </p>
                          </div>
                        </div>

                        <div
                          class="flex w-full max-w-[140px] items-center gap-3"
                        >
                          <div
                            class="relative block h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800"
                          >
                            <div
                              class="absolute left-0 top-0 flex h-full w-[85%] items-center justify-center rounded-sm bg-brand-500 text-xs font-medium text-white"
                            ></div>
                          </div>
                          <p
                            class="text-theme-sm font-medium text-gray-700 dark:text-gray-400"
                          >
                            85%
                          </p>
                        </div>
                      </div>
                    </div>

                    <div>
                      <p
                        class="mb-2 text-theme-sm text-gray-500 dark:text-gray-400"
                      >
                        Sales
                      </p>
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                          <div>
                            <p
                              class="text-base font-semibold text-gray-800 dark:text-white/90"
                            >
                              $20,486.00
                            </p>
                          </div>
                        </div>

                        <div
                          class="flex w-full max-w-[140px] items-center gap-3"
                        >
                          <div
                            class="relative block h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800"
                          >
                            <div
                              class="absolute left-0 top-0 flex h-full w-[55%] items-center justify-center rounded-sm bg-brand-500 text-xs font-medium text-white"
                            ></div>
                          </div>
                          <p
                            class="text-theme-sm font-medium text-gray-700 dark:text-gray-400"
                          >
                            55%
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ====== Chart Twelve End -->
              </div>

              <div class="col-span-12 xl:col-span-6">
                <!-- ====== Chart Thirteen Start -->
                <div
                  class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]"
                >
                  <div class="flex items-center justify-between mb-5">
                    <h3
                      class="text-lg font-semibold text-gray-800 dark:text-white/90"
                    >
                      Sales Category
                    </h3>

                    <div x-data="{openDropDown: false}" class="relative">
                      <button
                        @click="openDropDown = !openDropDown"
                        :class="openDropDown ? 'text-gray-700 dark:text-white' : 'text-gray-400 hover:text-gray-700 dark:hover:text-white'"
                      >
                        <svg
                          class="fill-current"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                            fill=""
                          />
                        </svg>
                      </button>
                      <div
                        x-show="openDropDown"
                        @click.outside="openDropDown = false"
                        class="absolute right-0 z-40 w-40 p-2 space-y-1 bg-white border border-gray-200 shadow-theme-lg dark:bg-gray-dark top-full rounded-2xl dark:border-gray-800"
                      >
                        <button
                          class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                        >
                          View More
                        </button>
                        <button
                          class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                        >
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-col items-center gap-8 xl:flex-row">
                    <div id="chartThirteen" class="chartDarkStyle"></div>
                    <div
                      class="flex flex-col items-start gap-6 sm:flex-row xl:flex-col"
                    >
                      <div class="flex items-start gap-2.5">
                        <div
                          class="bg-brand-500 mt-1.5 h-2 w-2 rounded-full"
                        ></div>
                        <div>
                          <h5
                            class="mb-1 font-medium text-gray-800 text-theme-sm dark:text-white/90"
                          >
                            Affiliate Program
                          </h5>
                          <div class="flex items-center gap-2">
                            <p
                              class="font-medium text-gray-700 text-theme-sm dark:text-gray-400"
                            >
                              48%
                            </p>
                            <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
                            <p
                              class="text-gray-500 text-theme-sm dark:text-gray-400"
                            >
                              2,040 Products
                            </p>
                          </div>
                        </div>
                      </div>

                      <div class="flex items-start gap-2.5">
                        <div
                          class="bg-brand-500 mt-1.5 h-2 w-2 rounded-full"
                        ></div>
                        <div>
                          <h5
                            class="mb-1 font-medium text-gray-800 text-theme-sm dark:text-white/90"
                          >
                            Direct Buy
                          </h5>
                          <div class="flex items-center gap-2">
                            <p
                              class="font-medium text-gray-700 text-theme-sm dark:text-gray-400"
                            >
                              33%
                            </p>
                            <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
                            <p
                              class="text-gray-400 text-theme-sm dark:text-gray-400"
                            >
                              1,402 Products
                            </p>
                          </div>
                        </div>
                      </div>

                      <div class="flex items-start gap-2.5">
                        <div
                          class="bg-brand-300 mt-1.5 h-2 w-2 rounded-full"
                        ></div>
                        <div>
                          <h5
                            class="mb-1 font-medium text-gray-800 text-theme-sm dark:text-white/90"
                          >
                            Adsense
                          </h5>
                          <div class="flex items-center gap-2">
                            <p
                              class="font-medium text-gray-700 text-theme-sm dark:text-gray-400"
                            >
                              19%
                            </p>
                            <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
                            <p
                              class="text-gray-500 text-theme-sm dark:text-gray-400"
                            >
                              510 Products
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ====== Chart Thirteen End -->
              </div>

              <div class="col-span-12 xl:col-span-6">
                <!-- ====== Upcoming Schedule Start -->
                <div
                  class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6"
                >
                  <div class="mb-6 flex items-center justify-between">
                    <h3
                      class="text-lg font-semibold text-gray-800 dark:text-white/90"
                    >
                      Upcoming Schedule
                    </h3>

                    <div x-data="{openDropDown: false}" class="relative">
                      <button
                        @click="openDropDown = !openDropDown"
                        :class="openDropDown ? 'text-gray-700 dark:text-white' : 'text-gray-400 hover:text-gray-700 dark:hover:text-white'"
                      >
                        <svg
                          class="fill-current"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                            fill=""
                          />
                        </svg>
                      </button>
                      <div
                        x-show="openDropDown"
                        @click.outside="openDropDown = false"
                        class="absolute right-0 top-full z-40 w-40 space-y-1 rounded-2xl border border-gray-200 bg-white p-2 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark"
                      >
                        <button
                          class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                        >
                          View More
                        </button>
                        <button
                          class="flex w-full rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                        >
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="custom-scrollbar max-w-full overflow-x-auto">
                    <div class="min-w-[500px]">
                      <div class="flex flex-col gap-2">
                        <div
                          x-data="{checked: false}"
                          @click="checked = !checked"
                          class="flex cursor-pointer items-center gap-9 rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-white/[0.03]"
                        >
                          <div class="flex items-start gap-3">
                            <div
                              class="flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]"
                              :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                            >
                              <svg
                                :class="checked ? 'block' : 'hidden'"
                                width="14"
                                height="14"
                                viewBox="0 0 14 14"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                  stroke="white"
                                  stroke-width="1.94437"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                />
                              </svg>
                            </div>
                            <div>
                              <span
                                class="mb-0.5 block text-theme-xs text-gray-500 dark:text-gray-400"
                              >
                                Wed, 11 jan
                              </span>
                              <span
                                class="text-theme-sm font-medium text-gray-700 dark:text-gray-400"
                              >
                                09:20 AM
                              </span>
                            </div>
                          </div>
                          <div>
                            <span
                              class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-400"
                            >
                              Business Analytics Press
                            </span>
                            <span
                              class="text-theme-xs text-gray-500 dark:text-gray-400"
                            >
                              Exploring the Future of Data-Driven +6 more
                            </span>
                          </div>
                        </div>

                        <div
                          x-data="{checked: false}"
                          @click="checked = !checked"
                          class="flex cursor-pointer items-center gap-9 rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-white/[0.03]"
                        >
                          <div class="flex items-start gap-3">
                            <div
                              class="flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]"
                              :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                            >
                              <svg
                                :class="checked ? 'block' : 'hidden'"
                                width="14"
                                height="14"
                                viewBox="0 0 14 14"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                  stroke="white"
                                  stroke-width="1.94437"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                />
                              </svg>
                            </div>
                            <div>
                              <span
                                class="mb-0.5 block text-theme-xs text-gray-500 dark:text-gray-400"
                              >
                                Fri, 15 feb
                              </span>
                              <span
                                class="text-theme-sm font-medium text-gray-700 dark:text-gray-400"
                              >
                                10:35 AM
                              </span>
                            </div>
                          </div>
                          <div>
                            <span
                              class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-400"
                            >
                              Business Sprint
                            </span>
                            <span
                              class="text-theme-xs text-gray-500 dark:text-gray-400"
                            >
                              Techniques from Business Sprint +2 more
                            </span>
                          </div>
                        </div>

                        <div
                          x-data="{checked: false}"
                          @click="checked = !checked"
                          class="flex cursor-pointer items-center gap-9 rounded-lg p-3 hover:bg-gray-50 dark:hover:bg-white/[0.03]"
                        >
                          <div class="flex items-start gap-3">
                            <div
                              class="flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]"
                              :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                            >
                              <svg
                                :class="checked ? 'block' : 'hidden'"
                                width="14"
                                height="14"
                                viewBox="0 0 14 14"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                  stroke="white"
                                  stroke-width="1.94437"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"
                                />
                              </svg>
                            </div>
                            <div>
                              <span
                                class="mb-0.5 block text-theme-xs text-gray-500 dark:text-gray-400"
                              >
                                Thu, 18 mar
                              </span>
                              <span
                                class="text-theme-sm font-medium text-gray-700 dark:text-gray-400"
                              >
                                1:15 AM
                              </span>
                            </div>
                          </div>
                          <div>
                            <span
                              class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-400"
                            >
                              Customer Review Meeting
                            </span>
                            <span
                              class="text-theme-xs text-gray-500 dark:text-gray-400"
                            >
                              Insights from the Customer Review Meeting +8 more
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ====== Upcoming Schedule End -->
              </div>

              <div class="col-span-12">
                <!-- Table Four -->
                <div
                  class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]"
                >
                  <div
                    class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between"
                  >
                    <div>
                      <h3
                        class="text-lg font-semibold text-gray-800 dark:text-white/90"
                      >
                        Recent Orders
                      </h3>
                    </div>

                    <div
                      class="flex flex-col gap-3 sm:flex-row sm:items-center"
                    >
                      <form>
                        <div class="relative">
                          <span
                            class="absolute -translate-y-1/2 pointer-events-none top-1/2 left-4"
                          >
                            <svg
                              class="fill-gray-500 dark:fill-gray-400"
                              width="20"
                              height="20"
                              viewBox="0 0 20 20"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.531 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z"
                                fill=""
                              />
                            </svg>
                          </span>
                          <input
                            type="text"
                            placeholder="Search..."
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-[42px] text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden xl:w-[300px] dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                          />
                        </div>
                      </form>
                      <div>
                        <button
                          class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                        >
                          <svg
                            class="stroke-current fill-white dark:fill-gray-800"
                            width="20"
                            height="20"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M2.29004 5.90393H17.7067"
                              stroke=""
                              stroke-width="1.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                            <path
                              d="M17.7075 14.0961H2.29085"
                              stroke=""
                              stroke-width="1.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                            />
                            <path
                              d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z"
                              fill=""
                              stroke=""
                              stroke-width="1.5"
                            />
                            <path
                              d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z"
                              fill=""
                              stroke=""
                              stroke-width="1.5"
                            />
                          </svg>

                          Filter
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="min-w-full">
                      <!-- table header start -->
                      <thead
                        class="border-gray-100 border-y bg-gray-50 dark:border-gray-800 dark:bg-gray-900"
                      >
                        <tr>
                          <th class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div
                                x-data="{checked: false}"
                                class="flex items-center gap-3"
                              >
                                <div
                                  @click="checked = !checked"
                                  class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                  :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                                >
                                  <svg
                                    :class="checked ? 'block' : 'hidden'"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                      stroke="white"
                                      stroke-width="1.94437"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                    />
                                  </svg>
                                </div>
                                <div>
                                  <span
                                    class="block font-medium text-gray-500 text-theme-xs dark:text-gray-400"
                                  >
                                    Deal ID
                                  </span>
                                </div>
                              </div>
                            </div>
                          </th>
                          <th class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
                              >
                                Customer
                              </p>
                            </div>
                          </th>
                          <th class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
                              >
                                Product/Service
                              </p>
                            </div>
                          </th>
                          <th class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
                              >
                                Deal Value
                              </p>
                            </div>
                          </th>
                          <th class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
                              >
                                Close Date
                              </p>
                            </div>
                          </th>
                          <th class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
                              >
                                Status
                              </p>
                            </div>
                          </th>
                          <th class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center justify-center">
                              <p
                                class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"
                              >
                                Action
                              </p>
                            </div>
                          </th>
                        </tr>
                      </thead>
                      <!-- table header end -->

                      <!-- table body start -->
                      <tbody
                        class="divide-y divide-gray-100 dark:divide-gray-800"
                      >
                        <tr>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div
                                x-data="{checked: false}"
                                class="flex items-center gap-3"
                              >
                                <div
                                  @click="checked = !checked"
                                  class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                  :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                                >
                                  <svg
                                    :class="checked ? 'block' : 'hidden'"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                      stroke="white"
                                      stroke-width="1.94437"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                    />
                                  </svg>
                                </div>
                                <div>
                                  <span
                                    class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400"
                                  >
                                    DE124321
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div
                                  class="flex items-center justify-center w-10 h-10 rounded-full bg-brand-100"
                                >
                                  <span
                                    class="text-xs font-semibold text-brand-500"
                                  >
                                    JD
                                  </span>
                                </div>
                                <div>
                                  <span
                                    class="text-theme-sm mb-0.5 block font-medium text-gray-700 dark:text-gray-400"
                                  >
                                    John Doe
                                  </span>
                                  <span
                                    class="text-gray-500 text-theme-sm dark:text-gray-400"
                                  >
                                    <a
                                      href="cdn-cgi/l/email-protection.html"
                                      class="__cf_email__"
                                      data-cfemail="1a707572747e7f755a7d777b737634797577"
                                      >[email&#160;protected]</a
                                    >
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                Software License
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                $18,50.34
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                2024-06-15
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 rounded-full px-2 py-0.5 font-medium"
                              >
                                Complete
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center justify-center">
                              <svg
                                class="cursor-pointer hover:fill-error-500 dark:hover:fill-error-500 fill-gray-700 dark:fill-gray-400"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  fill-rule="evenodd"
                                  clip-rule="evenodd"
                                  d="M6.54142 3.7915C6.54142 2.54886 7.54878 1.5415 8.79142 1.5415H11.2081C12.4507 1.5415 13.4581 2.54886 13.4581 3.7915V4.0415H15.6252H16.666C17.0802 4.0415 17.416 4.37729 17.416 4.7915C17.416 5.20572 17.0802 5.5415 16.666 5.5415H16.3752V8.24638V13.2464V16.2082C16.3752 17.4508 15.3678 18.4582 14.1252 18.4582H5.87516C4.63252 18.4582 3.62516 17.4508 3.62516 16.2082V13.2464V8.24638V5.5415H3.3335C2.91928 5.5415 2.5835 5.20572 2.5835 4.7915C2.5835 4.37729 2.91928 4.0415 3.3335 4.0415H4.37516H6.54142V3.7915ZM14.8752 13.2464V8.24638V5.5415H13.4581H12.7081H7.29142H6.54142H5.12516V8.24638V13.2464V16.2082C5.12516 16.6224 5.46095 16.9582 5.87516 16.9582H14.1252C14.5394 16.9582 14.8752 16.6224 14.8752 16.2082V13.2464ZM8.04142 4.0415H11.9581V3.7915C11.9581 3.37729 11.6223 3.0415 11.2081 3.0415H8.79142C8.37721 3.0415 8.04142 3.37729 8.04142 3.7915V4.0415ZM8.3335 7.99984C8.74771 7.99984 9.0835 8.33562 9.0835 8.74984V13.7498C9.0835 14.1641 8.74771 14.4998 8.3335 14.4998C7.91928 14.4998 7.5835 14.1641 7.5835 13.7498V8.74984C7.5835 8.33562 7.91928 7.99984 8.3335 7.99984ZM12.4168 8.74984C12.4168 8.33562 12.081 7.99984 11.6668 7.99984C11.2526 7.99984 10.9168 8.33562 10.9168 8.74984V13.7498C10.9168 14.1641 11.2526 14.4998 11.6668 14.4998C12.081 14.4998 12.4168 14.1641 12.4168 13.7498V8.74984Z"
                                  fill=""
                                />
                              </svg>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div
                                x-data="{checked: false}"
                                class="flex items-center gap-3"
                              >
                                <div
                                  @click="checked = !checked"
                                  class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                  :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                                >
                                  <svg
                                    :class="checked ? 'block' : 'hidden'"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                      stroke="white"
                                      stroke-width="1.94437"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                    />
                                  </svg>
                                </div>
                                <div>
                                  <span
                                    class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400"
                                  >
                                    DE124321
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div
                                  class="flex h-10 w-10 items-center justify-center rounded-full bg-[#fdf2fa]"
                                >
                                  <span
                                    class="text-xs font-semibold text-[#dd2590]"
                                  >
                                    KF
                                  </span>
                                </div>

                                <div>
                                  <span
                                    class="text-theme-sm mb-0.5 block font-medium text-gray-700 dark:text-gray-400"
                                  >
                                    Kierra Franci
                                  </span>
                                  <span
                                    class="text-gray-500 text-theme-sm dark:text-gray-400"
                                  >
                                    <a
                                      href="cdn-cgi/l/email-protection.html"
                                      class="__cf_email__"
                                      data-cfemail="22494b4750504362454f434b4e0c414d4f"
                                      >[email&#160;protected]</a
                                    >
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                Software License
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                $18,50.34
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                2024-06-15
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 rounded-full px-2 py-0.5 font-medium"
                              >
                                Complete
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center justify-center">
                              <svg
                                class="cursor-pointer hover:fill-error-500 dark:hover:fill-error-500 fill-gray-700 dark:fill-gray-400"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  fill-rule="evenodd"
                                  clip-rule="evenodd"
                                  d="M6.54142 3.7915C6.54142 2.54886 7.54878 1.5415 8.79142 1.5415H11.2081C12.4507 1.5415 13.4581 2.54886 13.4581 3.7915V4.0415H15.6252H16.666C17.0802 4.0415 17.416 4.37729 17.416 4.7915C17.416 5.20572 17.0802 5.5415 16.666 5.5415H16.3752V8.24638V13.2464V16.2082C16.3752 17.4508 15.3678 18.4582 14.1252 18.4582H5.87516C4.63252 18.4582 3.62516 17.4508 3.62516 16.2082V13.2464V8.24638V5.5415H3.3335C2.91928 5.5415 2.5835 5.20572 2.5835 4.7915C2.5835 4.37729 2.91928 4.0415 3.3335 4.0415H4.37516H6.54142V3.7915ZM14.8752 13.2464V8.24638V5.5415H13.4581H12.7081H7.29142H6.54142H5.12516V8.24638V13.2464V16.2082C5.12516 16.6224 5.46095 16.9582 5.87516 16.9582H14.1252C14.5394 16.9582 14.8752 16.6224 14.8752 16.2082V13.2464ZM8.04142 4.0415H11.9581V3.7915C11.9581 3.37729 11.6223 3.0415 11.2081 3.0415H8.79142C8.37721 3.0415 8.04142 3.37729 8.04142 3.7915V4.0415ZM8.3335 7.99984C8.74771 7.99984 9.0835 8.33562 9.0835 8.74984V13.7498C9.0835 14.1641 8.74771 14.4998 8.3335 14.4998C7.91928 14.4998 7.5835 14.1641 7.5835 13.7498V8.74984C7.5835 8.33562 7.91928 7.99984 8.3335 7.99984ZM12.4168 8.74984C12.4168 8.33562 12.081 7.99984 11.6668 7.99984C11.2526 7.99984 10.9168 8.33562 10.9168 8.74984V13.7498C10.9168 14.1641 11.2526 14.4998 11.6668 14.4998C12.081 14.4998 12.4168 14.1641 12.4168 13.7498V8.74984Z"
                                  fill=""
                                />
                              </svg>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div
                                x-data="{checked: false}"
                                class="flex items-center gap-3"
                              >
                                <div
                                  @click="checked = !checked"
                                  class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                  :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                                >
                                  <svg
                                    :class="checked ? 'block' : 'hidden'"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                      stroke="white"
                                      stroke-width="1.94437"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                    />
                                  </svg>
                                </div>
                                <div>
                                  <span
                                    class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400"
                                  >
                                    DE124321
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div
                                  class="flex h-10 w-10 items-center justify-center rounded-full bg-[#f0f9ff]"
                                >
                                  <span
                                    class="text-xs font-semibold text-[#0086c9]"
                                  >
                                    EW
                                  </span>
                                </div>

                                <div>
                                  <span
                                    class="text-theme-sm mb-0.5 block font-medium text-gray-700 dark:text-gray-400"
                                  >
                                    Emerson Workman
                                  </span>
                                  <span
                                    class="text-gray-500 text-theme-sm dark:text-gray-400"
                                  >
                                    <a
                                      href="cdn-cgi/l/email-protection.html"
                                      class="__cf_email__"
                                      data-cfemail="3f5a525a4d4c50517f58525e5653115c5052"
                                      >[email&#160;protected]</a
                                    >
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                Software License
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                $18,50.34
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                2024-06-15
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="bg-warning-50 text-theme-xs text-warning-600 dark:bg-warning-500/15 dark:text-warning-400 rounded-full px-2 py-0.5 font-medium"
                              >
                                Pending
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center justify-center">
                              <svg
                                class="cursor-pointer hover:fill-error-500 dark:hover:fill-error-500 fill-gray-700 dark:fill-gray-400"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  fill-rule="evenodd"
                                  clip-rule="evenodd"
                                  d="M6.54142 3.7915C6.54142 2.54886 7.54878 1.5415 8.79142 1.5415H11.2081C12.4507 1.5415 13.4581 2.54886 13.4581 3.7915V4.0415H15.6252H16.666C17.0802 4.0415 17.416 4.37729 17.416 4.7915C17.416 5.20572 17.0802 5.5415 16.666 5.5415H16.3752V8.24638V13.2464V16.2082C16.3752 17.4508 15.3678 18.4582 14.1252 18.4582H5.87516C4.63252 18.4582 3.62516 17.4508 3.62516 16.2082V13.2464V8.24638V5.5415H3.3335C2.91928 5.5415 2.5835 5.20572 2.5835 4.7915C2.5835 4.37729 2.91928 4.0415 3.3335 4.0415H4.37516H6.54142V3.7915ZM14.8752 13.2464V8.24638V5.5415H13.4581H12.7081H7.29142H6.54142H5.12516V8.24638V13.2464V16.2082C5.12516 16.6224 5.46095 16.9582 5.87516 16.9582H14.1252C14.5394 16.9582 14.8752 16.6224 14.8752 16.2082V13.2464ZM8.04142 4.0415H11.9581V3.7915C11.9581 3.37729 11.6223 3.0415 11.2081 3.0415H8.79142C8.37721 3.0415 8.04142 3.37729 8.04142 3.7915V4.0415ZM8.3335 7.99984C8.74771 7.99984 9.0835 8.33562 9.0835 8.74984V13.7498C9.0835 14.1641 8.74771 14.4998 8.3335 14.4998C7.91928 14.4998 7.5835 14.1641 7.5835 13.7498V8.74984C7.5835 8.33562 7.91928 7.99984 8.3335 7.99984ZM12.4168 8.74984C12.4168 8.33562 12.081 7.99984 11.6668 7.99984C11.2526 7.99984 10.9168 8.33562 10.9168 8.74984V13.7498C10.9168 14.1641 11.2526 14.4998 11.6668 14.4998C12.081 14.4998 12.4168 14.1641 12.4168 13.7498V8.74984Z"
                                  fill=""
                                />
                              </svg>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div
                                x-data="{checked: false}"
                                class="flex items-center gap-3"
                              >
                                <div
                                  @click="checked = !checked"
                                  class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                  :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                                >
                                  <svg
                                    :class="checked ? 'block' : 'hidden'"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                      stroke="white"
                                      stroke-width="1.94437"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                    />
                                  </svg>
                                </div>
                                <div>
                                  <span
                                    class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400"
                                  >
                                    DE124321
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div
                                  class="flex h-10 w-10 items-center justify-center rounded-full bg-[#fff6ed]"
                                >
                                  <span
                                    class="text-xs font-semibold text-[#ec4a0a]"
                                  >
                                    CP
                                  </span>
                                </div>

                                <div>
                                  <span
                                    class="text-theme-sm mb-0.5 block font-medium text-gray-700 dark:text-gray-400"
                                  >
                                    Chance Philips
                                  </span>
                                  <span
                                    class="text-gray-500 text-theme-sm dark:text-gray-400"
                                  >
                                    <a
                                      href="cdn-cgi/l/email-protection.html"
                                      class="__cf_email__"
                                      data-cfemail="05666d646b6660456268646c692b666a68"
                                      >[email&#160;protected]</a
                                    >
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                Software License
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                $18,50.34
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                2024-06-15
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 rounded-full px-2 py-0.5 font-medium"
                              >
                                Complete
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center justify-center">
                              <svg
                                class="cursor-pointer hover:fill-error-500 dark:hover:fill-error-500 fill-gray-700 dark:fill-gray-400"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  fill-rule="evenodd"
                                  clip-rule="evenodd"
                                  d="M6.54142 3.7915C6.54142 2.54886 7.54878 1.5415 8.79142 1.5415H11.2081C12.4507 1.5415 13.4581 2.54886 13.4581 3.7915V4.0415H15.6252H16.666C17.0802 4.0415 17.416 4.37729 17.416 4.7915C17.416 5.20572 17.0802 5.5415 16.666 5.5415H16.3752V8.24638V13.2464V16.2082C16.3752 17.4508 15.3678 18.4582 14.1252 18.4582H5.87516C4.63252 18.4582 3.62516 17.4508 3.62516 16.2082V13.2464V8.24638V5.5415H3.3335C2.91928 5.5415 2.5835 5.20572 2.5835 4.7915C2.5835 4.37729 2.91928 4.0415 3.3335 4.0415H4.37516H6.54142V3.7915ZM14.8752 13.2464V8.24638V5.5415H13.4581H12.7081H7.29142H6.54142H5.12516V8.24638V13.2464V16.2082C5.12516 16.6224 5.46095 16.9582 5.87516 16.9582H14.1252C14.5394 16.9582 14.8752 16.6224 14.8752 16.2082V13.2464ZM8.04142 4.0415H11.9581V3.7915C11.9581 3.37729 11.6223 3.0415 11.2081 3.0415H8.79142C8.37721 3.0415 8.04142 3.37729 8.04142 3.7915V4.0415ZM8.3335 7.99984C8.74771 7.99984 9.0835 8.33562 9.0835 8.74984V13.7498C9.0835 14.1641 8.74771 14.4998 8.3335 14.4998C7.91928 14.4998 7.5835 14.1641 7.5835 13.7498V8.74984C7.5835 8.33562 7.91928 7.99984 8.3335 7.99984ZM12.4168 8.74984C12.4168 8.33562 12.081 7.99984 11.6668 7.99984C11.2526 7.99984 10.9168 8.33562 10.9168 8.74984V13.7498C10.9168 14.1641 11.2526 14.4998 11.6668 14.4998C12.081 14.4998 12.4168 14.1641 12.4168 13.7498V8.74984Z"
                                  fill=""
                                />
                              </svg>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div
                                x-data="{checked: false}"
                                class="flex items-center gap-3"
                              >
                                <div
                                  @click="checked = !checked"
                                  class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                  :class="checked ? 'border-brand-500 dark:border-brand-500 bg-brand-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700' "
                                >
                                  <svg
                                    :class="checked ? 'block' : 'hidden'"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 14 14"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path
                                      d="M11.6668 3.5L5.25016 9.91667L2.3335 7"
                                      stroke="white"
                                      stroke-width="1.94437"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                    />
                                  </svg>
                                </div>
                                <div>
                                  <span
                                    class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400"
                                  >
                                    DE124321
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex items-center gap-3">
                                <div
                                  class="flex items-center justify-center w-10 h-10 rounded-full bg-success-50"
                                >
                                  <span
                                    class="text-xs font-semibold text-success-600"
                                  >
                                    TG
                                  </span>
                                </div>

                                <div>
                                  <span
                                    class="text-theme-sm mb-0.5 block font-medium text-gray-700 dark:text-gray-400"
                                  >
                                    Terry Geidt
                                  </span>
                                  <span
                                    class="text-gray-500 text-theme-sm dark:text-gray-400"
                                  >
                                    <a
                                      href="cdn-cgi/l/email-protection.html"
                                      class="__cf_email__"
                                      data-cfemail="97e3f2e5e5eed7f0faf6fefbb9f4f8fa"
                                      >[email&#160;protected]</a
                                    >
                                  </span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                Software License
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                $18,50.34
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="text-gray-700 text-theme-sm dark:text-gray-400"
                              >
                                2024-06-15
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                              <p
                                class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 rounded-full px-2 py-0.5 font-medium"
                              >
                                Complete
                              </p>
                            </div>
                          </td>
                          <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center justify-center">
                              <svg
                                class="cursor-pointer hover:fill-error-500 dark:hover:fill-error-500 fill-gray-700 dark:fill-gray-400"
                                width="20"
                                height="20"
                                viewBox="0 0 20 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                              >
                                <path
                                  fill-rule="evenodd"
                                  clip-rule="evenodd"
                                  d="M6.54142 3.7915C6.54142 2.54886 7.54878 1.5415 8.79142 1.5415H11.2081C12.4507 1.5415 13.4581 2.54886 13.4581 3.7915V4.0415H15.6252H16.666C17.0802 4.0415 17.416 4.37729 17.416 4.7915C17.416 5.20572 17.0802 5.5415 16.666 5.5415H16.3752V8.24638V13.2464V16.2082C16.3752 17.4508 15.3678 18.4582 14.1252 18.4582H5.87516C4.63252 18.4582 3.62516 17.4508 3.62516 16.2082V13.2464V8.24638V5.5415H3.3335C2.91928 5.5415 2.5835 5.20572 2.5835 4.7915C2.5835 4.37729 2.91928 4.0415 3.3335 4.0415H4.37516H6.54142V3.7915ZM14.8752 13.2464V8.24638V5.5415H13.4581H12.7081H7.29142H6.54142H5.12516V8.24638V13.2464V16.2082C5.12516 16.6224 5.46095 16.9582 5.87516 16.9582H14.1252C14.5394 16.9582 14.8752 16.6224 14.8752 16.2082V13.2464ZM8.04142 4.0415H11.9581V3.7915C11.9581 3.37729 11.6223 3.0415 11.2081 3.0415H8.79142C8.37721 3.0415 8.04142 3.37729 8.04142 3.7915V4.0415ZM8.3335 7.99984C8.74771 7.99984 9.0835 8.33562 9.0835 8.74984V13.7498C9.0835 14.1641 8.74771 14.4998 8.3335 14.4998C7.91928 14.4998 7.5835 14.1641 7.5835 13.7498V8.74984C7.5835 8.33562 7.91928 7.99984 8.3335 7.99984ZM12.4168 8.74984C12.4168 8.33562 12.081 7.99984 11.6668 7.99984C11.2526 7.99984 10.9168 8.33562 10.9168 8.74984V13.7498C10.9168 14.1641 11.2526 14.4998 11.6668 14.4998C12.081 14.4998 12.4168 14.1641 12.4168 13.7498V8.74984Z"
                                  fill=""
                                />
                              </svg>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                      <!-- table body end -->
                    </table>
                  </div>
                </div>
                <!-- Table Four -->
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
