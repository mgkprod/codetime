<template>
  <div class="flex flex-col items-start w-full mx-auto mb-8 overflow-hidden bg-white rounded shadow-sm">
    <div class="w-full px-5 py-4 font-semibold bg-gray-50">WakaTime config file</div>
    <div class="w-full px-5 py-4">
      <p class="mb-2">CodeTime relies on WakaTime plugins to retrieve code statistics.</p>
      <p class="mb-2">
        In order to connect the plugins, you must specify a custom server in the global configuration file.<br />
        This file is usually located in your user folder :
      </p>
      <ul class="mb-2">
        <li><code>C:\Users\{username}\.wakatime.cfg</code> on Windows</li>
        <li><code>/home/{username}/.wakatime.cfg</code> on Linux</li>
      </ul>

      <p class="mb-2">Put the following in your <code>.wakatime.cfg</code> file :</p>
      <pre class="p-2 mb-2 border">{{ wakacfg }}</pre>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../layouts/app').default,

  props: ['wakacfg'],
};
</script>
