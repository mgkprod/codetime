<template>
  <div>
    <div class="flex flex-row space-x-8">
      <div class="w-1/3 px-8 py-4 mx-auto mb-8 bg-white border-l-4 border-[#DD524D] shadow-xl shadow-gray-200">
        <div class="text-sm font-bold">Total coding time</div>
        <div>{{ totalCodingTime }}</div>
      </div>
      <div class="w-1/3 px-8 py-4 mx-auto mb-8 bg-white border-l-4 border-[#DD524D] shadow-xl shadow-gray-200">
        <div class="text-sm font-bold">Total projects</div>
        <div>{{ totalProjects }}</div>
      </div>
      <div class="w-1/3 px-8 py-4 mx-auto mb-8 bg-white border-l-4 border-[#DD524D] shadow-xl shadow-gray-200">
        <div class="text-sm font-bold">Most active project</div>
        <div>{{ mostActiveProject }}</div>
      </div>
    </div>

    <div class="flex flex-row space-x-8">
      <div class="flex flex-col w-3/5 p-8 mx-auto mb-8 space-y-4 bg-white shadow-xl shadow-gray-200">
        <div class="font-bold">Coding activity</div>
        <hr class="w-full border-gray-200" />

        <div ref="codingActivity"></div>
      </div>
      <div class="flex flex-col w-2/5 p-8 mx-auto mb-8 space-y-4 bg-white shadow-xl shadow-gray-200">
        <div class="font-bold">Projects breakdown</div>
        <hr class="w-full border-gray-200" />

        <div ref="projectsBreakdown"></div>
      </div>
    </div>

    <div class="flex flex-row space-x-8">
      <div class="flex flex-col w-1/2 p-8 mx-auto mb-8 space-y-4 bg-white shadow-xl shadow-gray-200">
        <div class="font-bold">Activity per project</div>
        <hr class="w-full border-gray-200" />

        <div ref="activityPerProject"></div>
      </div>
      <div class="flex flex-col w-1/2 p-8 mx-auto mb-8 space-y-4 bg-white shadow-xl shadow-gray-200">
        <div class="font-bold">Timeline</div>
        <hr class="w-full border-gray-200" />

        <div ref="timeline"></div>
      </div>
    </div>
  </div>
</template>

<script>
import ApexCharts from 'apexcharts';

export default {
  layout: require('../layouts/app').default,

  data() {
    return {
      totalCodingTime: undefined,
      totalProjects: undefined,
      mostActiveProject: undefined,
    };
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    secondsToH(seconds) {
      let d = moment.duration(seconds, 'seconds').hours();
      return d + 'h';
    },

    secondsToHm(seconds) {
      let d = moment.duration(seconds, 'seconds');
      let formatted = d.hours() + 'h' + d.minutes() + 'm';

      if (d.days()) formatted = d.days() + 'd' + formatted;

      return formatted;
    },

    fetchData() {
      axios.get(route('dashboard.data')).then(({ data }) => {
        this.totalCodingTime = data.totalCodingTime;
        this.totalProjects = data.totalProjects;
        this.mostActiveProject = data.mostActiveProject;

        // codingActivity
        new ApexCharts(this.$refs.codingActivity, {
          series: [{ name: 'Total coding time', data: data.codingActivity.data }],
          chart: { height: 350, type: 'bar' },
          plotOptions: { bar: { borderRadius: 5, dataLabels: { position: 'top' } } },
          dataLabels: { enabled: true, formatter: this.secondsToHm, offsetY: -25, style: { colors: ['#374151'] } },
          xaxis: { categories: data.codingActivity.categories },
          yaxis: { labels: { formatter: this.secondsToH } },
        }).render();

        // projectsBreakdown
        new ApexCharts(this.$refs.projectsBreakdown, {
          series: data.projectsBreakdown.data,
          chart: { height: 350, type: 'donut' },
          responsive: [{ breakpoint: 500, options: { chart: { width: 350 }, legend: { position: 'bottom' } } }],
          labels: data.projectsBreakdown.labels,
          yaxis: { labels: { formatter: this.secondsToHm } },
        }).render();

        // activityPerProject
        new ApexCharts(this.$refs.activityPerProject, {
          series: data.activityPerProject.series,
          chart: { height: data.activityPerProject.series.length * 25, type: 'heatmap' },
          plotOptions: { heatmap: { distributed: true } },
          tooltip: { y: { formatter: this.secondsToHm } },
          dataLabels: { enabled: false, formatter: this.secondsToHm },
          xaxis: { type: 'category', categories: data.activityPerProject.categories },
        }).render();

        // timeline
        new ApexCharts(this.$refs.timeline, {
          series: [{ data: data.timeline.data }],
          chart: { height: data.activityPerProject.series.length * 25, type: 'rangeBar' },
          plotOptions: { bar: { horizontal: true } },
          tooltip: {
            x: {
              formatter: (value) => (Number.isInteger(value) ? new Date(value).toISOString().substr(11, 8) : value),
            },
          },
          // dataLabels: { enabled: false, formatter: this.secondsToHm },
          xaxis: { type: 'datetime' },
        }).render();
      });
    },
  },
};
</script>
