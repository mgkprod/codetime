<template>
  <div class="flex flex-col items-start min-h-screen bg-gray-100">
    <nav class="w-full mb-8 bg-white border-b border-gray-200">
      <div class="container max-w-screen-xl px-4 mx-auto">
        <div class="flex flex-wrap items-center">
          <inertia-link :href="route('index')">
            <div class="flex flex-row items-center h-16">
              <img src="/images/logo.svg" alt="Rocket" class="h-8" />
            </div>
          </inertia-link>

          <button class="ml-auto text-gray-600 md:hidden focus:outline-none" @click="toggle">
            <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
              <path v-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
              <path v-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>

          <div :class="open ? 'flex' : 'hidden'" class="flex-col flex-grow w-full py-2 -mx-1 md:flex md:py-0 md:flex-row md:items-center md:w-auto md:pl-8">
            <inertia-link
              :href="route('dashboard')"
              :class="{
                'bg-gray-100': route().current('dashboard*'),
              }"
              class="inline-block px-4 py-2 mx-1 mb-2 text-sm font-semibold text-gray-600 transition duration-200 ease-in-out rounded md:mb-0 hover:bg-gray-200"
            >
              <i class="mr-1 opacity-50 fas fa-chart-line"></i> Dashboard
            </inertia-link>

            <inertia-link
              :href="route('wakacfg')"
              :class="{
                'bg-gray-100': route().current('wakacfg*'),
              }"
              class="inline-block px-4 py-2 mx-1 mb-2 text-sm font-semibold text-gray-600 transition duration-200 ease-in-out rounded md:mb-0 hover:bg-gray-200"
            >
              <i class="mr-1 opacity-50 fas fa-cog"></i> WakaTime Configuration
            </inertia-link>

            <div class="hidden ml-auto md:block"></div>

            <button type="button" class="inline-block px-4 py-2 mx-1 mb-2 text-sm font-semibold text-left text-gray-600 transition duration-200 ease-in-out rounded md:mb-0 hover:bg-gray-200" @click="$inertia.post(route('logout'))"><i class="mr-1 opacity-50 fas fa-sign-out-alt"></i> Sign out</button>
          </div>
        </div>
      </div>
    </nav>

    <alerts></alerts>

    <div class="container max-w-screen-xl px-4 mx-auto text-gray-700">
      <slot />
    </div>

    <footer class="container flex flex-row justify-between w-full px-4 py-8 mx-auto mt-auto text-xs text-center text-gray-400">
      <div>{{ $page.props.version }}</div>
      <div>Made with ♥ by <a href="https://mgk.dev" class="hover:underline" target="_blank">Simon Rubuano</a> as <a href="https://github.com/mgkprod/codetime" class="hover:underline" target="_blank">open-source software</a>.</div>
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      open: false,
    };
  },

  methods: {
    toggle() {
      this.open = !this.open;
    },
  },
};
</script>