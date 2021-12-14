<template>
  <div class="flex flex-col items-center justify-center w-full min-h-screen py-8 text-gray-700 bg-gray-100">
    <img src="/images/logo.svg" alt="CodeTime" class="h-16 mx-auto mb-8" />

    <slot />

    <div class="mt-8 text-sm text-center text-gray-400">
      <p>Made with ♥ by <a href="https://mgk.dev" class="hover:underline" target="_blank">Simon Rubuano</a> as <a href="https://github.com/mgkprod/codetime" class="hover:underline" target="_blank">open-source software</a>.</p>
      <p class="text-xs">{{ $page.props.version }}</p>
    </div>
  </div>
</template>

<script>
export default {
  //
};
</script>