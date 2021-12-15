<template>
  <div class="max-w-lg mx-auto">
    <div class="flex flex-col items-start w-full mx-auto mb-8 p-8 overflow-hidden rounded-lg shadow-xl bg-[#272844]">
      <div class="mb-8 text-lg text-white font-tomorrow">
        Environement configuration
        <div class="w-24 border-b-2 border-current"></div>
      </div>

      <p class="mb-4">codetracker█ relies on <a href="https://wakatime.com/plugins" target="_blank" class="transition duration-200 ease-in-out border-b border-current hover:border-white hover:text-white">WakaTime plugins</a> to retrieve code statistics.</p>

      <p class="mb-4">
        In order to connect the plugins, you must specify a custom server in the global WakaTime configuration file.<br />
        This file is usually located in your user folder:
      </p>

      <ul class="mb-4">
        <li><code class="text-[#7C8EB6]">/home/{username}/.wakatime.cfg</code> on macOS and Linux,</li>
        <li><code class="text-[#7C8EB6]">C:\Users\{username}\.wakatime.cfg</code> on Windows</li>
      </ul>

      <p class="mb-4">Replace the contents with the followings in your <code class="text-[#7C8EB6]">.wakatime.cfg</code> file:</p>

      <pre class="p-4 border text-[#7C8EB6] border-[#7C8EB6] w-full">{{ wakacfg }}</pre>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../layouts/app').default,

  props: ['wakacfg'],
};
</script>
