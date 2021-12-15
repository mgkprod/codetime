<template>
  <div class="flex flex-col items-start min-h-screen">
    <nav class="w-full my-8">
      <div class="container max-w-screen-xl px-8 mx-auto">
        <div class="flex flex-wrap items-center">
          <inertia-link :href="route('index')" class="font-bold">codetracker<span class="flicker">█</span></inertia-link>

          <button class="ml-auto text-white md:hidden focus:outline-none" @click="toggle">
            <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
              <path v-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
              <path v-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>

          <div :class="open ? 'flex' : 'hidden'" class="flex-col flex-grow w-full py-2 -mx-1 space-y-4 md:flex md:py-0 md:flex-row md:items-center md:w-auto md:pl-8 md:justify-end md:space-y-0 md:space-x-4">
            <inertia-link
              :href="route('dashboard')"
              :class="{
                'text-white bg-[#DD524D]': route().current('dashboard*'),
                'hover:bg-gray-200': !route().current('dashboard*'),
              }"
              class="inline-block px-4 py-2 text-sm font-bold transition duration-200 ease-in-out"
            >
              <i class="mr-1 opacity-50 fas fa-chart-line"></i> Dashboard
            </inertia-link>

            <inertia-link
              :href="route('wakacfg')"
              :class="{
                'text-white bg-[#DD524D]': route().current('wakacfg*'),
                'hover:bg-gray-200': !route().current('wakacfg*'),
              }"
              class="inline-block px-4 py-2 text-sm font-bold transition duration-200 ease-in-out"
            >
              <i class="mr-1 opacity-50 fas fa-cog"></i> Settings
            </inertia-link>

            <button type="button" class="inline-block px-4 py-2 text-sm font-bold transition duration-200 ease-in-out hover:bg-gray-200 hover:text-black focus:outline-none" @click="$inertia.post(route('logout'))"><i class="fas fa-sign-out-alt"></i></button>
          </div>
        </div>
      </div>
    </nav>

    <alerts></alerts>

    <div class="container max-w-screen-xl px-8 mx-auto">
      <slot />
    </div>

    <footer class="container flex flex-row justify-between w-full max-w-screen-xl px-8 py-4 mx-auto my-8 mt-auto text-xs text-center text-gray-400">
      <div>{{ $page.props.version }}</div>
      <div>Made with ♥ by <a href="https://mgk.dev" class="transition duration-200 ease-in-out border-b border-current hover:opacity-80" target="_blank">Simon Rubuano</a> as <a href="https://github.com/mgkprod/codetracker" class="transition duration-200 ease-in-out border-b border-current hover:opacity-80" target="_blank">open-source software</a>.</div>
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