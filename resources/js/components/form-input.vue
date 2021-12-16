<template>
  <label class="block">
    <span v-if="label" class="block mb-2 text-sm font-semibold text-gray-700" v-text="label"></span>
    <input class="w-full px-3 py-3 text-sm leading-tight text-gray-700 transition duration-200 ease-in-out bg-gray-100 appearance-none focus:outline-none" :class="{ 'bg-red-100 mb-1': errors.length }" v-bind="$attrs" v-on="{ ...$listeners, input: (event) => $emit('input', event.target.value) }" />
    <p v-if="errors.length" class="pl-1 text-xs italic font-semibold text-[#DD524D]" v-text="errors[0]"></p>
  </label>
</template>

<script>
export default {
  inheritAttrs: false,

  props: {
    id: String,
    label: String,

    errors: {
      type: Array,
      default: () => [],
    },
  },
};
</script>