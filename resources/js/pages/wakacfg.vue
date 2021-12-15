<template>
  <div class="w-full max-w-xl mx-auto">
    <div class="flex flex-col p-8 mx-auto mb-8 space-y-4 bg-white shadow-xl shadow-gray-200">
      <div class="font-bold">Environement configuration</div>
      <hr class="w-full border-gray-200" />

      <p>codetracker█ relies on <a href="https://wakatime.com/plugins" target="_blank" class="transition duration-200 ease-in-out border-b border-current hover:opacity-80">WakaTime plugins</a> to retrieve code statistics.</p>
      <p>In order to connect the plugins, you must specify a custom server in the global WakaTime configuration file.</p>

      <p>This file is usually located in your user folder:</p>
      <ul>
        <li><code class="inline-block px-2 py-1 bg-gray-100 rounded">/home/{username}/.wakatime.cfg</code> on macOS and Linux,</li>
        <li><code class="inline-block px-2 py-1 bg-gray-100 rounded">C:\Users\{username}\.wakatime.cfg</code> on Windows</li>
      </ul>

      <div class="p-4 text-yellow-700 bg-yellow-200 border-l-4 border-yellow-300">
        <span class="font-bold"></span>
        If you're using Sublime Text, you may find your configuration file <a class="transition duration-200 ease-in-out border-b border-current hover:opacity-80" href="https://github.com/wakatime/sublime-wakatime#troubleshooting" target="_blank">elsewhere</a>.
      </div>

      <p>Replace the contents with the followings:</p>
      <pre class="w-full p-4 bg-gray-100 border-l-4 border-gray-300">{{ wakacfg }}</pre>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../layouts/app').default,

  props: ['wakacfg'],
};
</script>
