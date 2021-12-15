<template>
  <div class="w-full max-w-lg mx-auto">
    <form class="flex flex-col p-8 mx-auto bg-white shadow-xl shadow-gray-200" @submit.prevent="submit">
      <div class="font-bold">Sign in to your account</div>

      <hr class="w-full my-4 border-gray-200" />

      <form-input label="Email" placeholder="Your email address" v-model="form.email" :errors="$page.props.errors.email" autofocus autocomplete="email" />
      <form-input class="mt-4" label="Password" placeholder="Your password" type="password" v-model="form.password" :errors="$page.props.errors.password" autocomplete="current-password" />

      <div class="flex justify-end mt-8">
        <button class="inline-block px-4 py-2 text-sm font-bold transition duration-200 ease-in-out bg-gray-200 hover:bg-gray-300 hover:text-black focus:outline-none"><i class="mr-1 fas fa-sign-in-alt"></i> Sign in</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  layout: require('../../layouts/gate').default,

  data() {
    return {
      form: {
        email: '',
        password: '',
      },
    };
  },

  methods: {
    submit() {
      this.$page.props.errors = {};

      this.$inertia.post(this.route('login'), { ...this.form });

      this.form.password = '';
    },
  },
};
</script>