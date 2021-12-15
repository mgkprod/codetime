<template>
  <div class="flex flex-col items-center justify-center w-full min-h-screen py-8">
    <img src="/images/logo.svg" class="h-8 mx-auto mb-8" />

    <slot />

    <div class="mt-8 text-xs text-center text-gray-400">
      <p>Made with ♥ by <a href="https://mgk.dev" class="transition duration-200 ease-in-out border-b border-current hover:border-white hover:text-white" target="_blank">Simon Rubuano</a> as <a href="https://github.com/mgkprod/codetracker" class="transition duration-200 ease-in-out border-b border-current hover:border-white hover:text-white" target="_blank">open-source software</a>.</p>
      <p>{{ $page.props.version }}</p>
    </div>
  </div>
</template>

<script>
export default {
  //
};
</script>