<template>
  <div class="max-w-lg mx-auto">
    <form class="w-full" @submit.prevent="submit">
      <div class="flex flex-col items-start w-full mx-auto mb-8 p-8 overflow-hidden rounded-lg shadow-xl bg-[#272844]">
        <div class="mb-8 text-lg text-white font-tomorrow">
          Sign in to your account
          <div class="w-24 border-b-2 border-current"></div>
        </div>

        <div class="mb-4">
          <form-input class="mb-4" label="Email" placeholder="Your Email Address" v-model="form.email" :errors="$page.props.errors.email" required autofocus autocomplete="email" />
          <form-input class="mb-4" label="Password" placeholder="Your Password" type="password" v-model="form.password" :errors="$page.props.errors.password" required autocomplete="current-password" />
        </div>
      </div>

      <div class="flex justify-end">
        <button class="inline-block px-4 py-2 text-sm font-semibold transition duration-200 ease-in-out rounded-lg hover:text-white"><i class="mr-1 fas fa-sign-in-alt"></i> Sign in</button>
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