<template>
  <div>
    <div class="flex flex-col items-start w-full mx-auto mb-8 p-8 overflow-hidden rounded-lg shadow-xl bg-[#272844]">
      <div class="mb-8 text-lg text-white font-tomorrow">
        Coding activity
        <div class="w-24 border-b-2 border-current"></div>
      </div>

      <div class="w-full px-5 py-4 bg-white rounded-lg">
        <canvas ref="coding-activity" class="w-100" style="height: 500px"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: require('../layouts/app').default,

  data() {
    return {
      codingActivity: undefined,
    };
  },

  mounted() {
    this.fetch();
  },

  methods: {
    fetch() {
      axios.get(route('dashboard.data')).then(({ data }) => {
        this.codingActivity = data.codingActivity;
        this.render();
      });
    },
    render() {
      let labels = this.codingActivity.labels;
      let datasets = this.codingActivity.datasets;
      let ctx = this.$refs['coding-activity'].getContext('2d');

      new Chart(ctx, {
        type: 'bar',
        data: { labels, datasets },
        options: {
          tooltips: {
            mode: 'index',
            intersect: false,
            callbacks: {
              label: (tooltipItem, data) => {
                if (tooltipItem.yLabel == 0) return;

                let label = data.datasets[tooltipItem.datasetIndex].label || '';
                label += ': ' + this.secondsToHms(tooltipItem.yLabel);

                return label;
              },
            },
          },
          responsive: true,
          scales: {
            xAxes: [{ stacked: true }],
            yAxes: [
              {
                stacked: true,
                ticks: {
                  callback: (value, index, values) => this.secondsToH(value),
                },
              },
            ],
          },
        },
      });
    },

    secondsToH(d) {
      var h = moment('1900-01-01 00:00:00').add(d, 'seconds').format('HH');
      return h + 'h';
    },

    secondsToHms(d) {
      var d = moment('1900-01-01 00:00:00').add(d, 'seconds').format('HH:mm:ss');
      return d;
    },
  },
};
</script>
