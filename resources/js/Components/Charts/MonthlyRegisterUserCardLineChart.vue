<script setup>
import Chart from "chart.js";
import { computed, onMounted } from "vue";

const props = defineProps({
  thisYearMonthlyUserRegisterLables: Object,
  thisYearMonthlyUserRegisterData: Object,
  lastYearMonthlyUserRegisterLables: Object,
  lastYearMonthlyUserRegisterData: Object,
});

const monthNames = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

const formattedMonths = computed(() => {
  return props.thisYearMonthlyUserRegisterLables.map(
    (month) => monthNames[month - 1]
  );
});

onMounted(() => {
  var config = {
    type: "line",
    data: {
      labels: formattedMonths.value,
      datasets: [
        {
          label: new Date().getFullYear(),
          backgroundColor: "#d74c1d",
          borderColor: "#d74c1d",
          data: props.thisYearMonthlyUserRegisterData,
          fill: false,
          tension: 0.1,
        },
        {
          label: new Date().getFullYear() - 1,
          fill: false,
          backgroundColor: "#006b9c",
          borderColor: "#006b9c",
          data: props.lastYearMonthlyUserRegisterData,
          tension: 0.1,
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      responsive: true,
      title: {
        display: false,
        text: "User Register",
        fontColor: "gray",
      },
      legend: {
        labels: {
          fontColor: "gray",
        },
        align: "end",
        position: "bottom",
      },
      tooltips: {
        mode: "index",
        intersect: false,
      },
      hover: {
        mode: "nearest",
        intersect: true,
      },
      scales: {
        xAxes: [
          {
            display: false,
            scaleLabel: {
              display: true,
              labelString: "Month",
            },
            gridLines: {
              borderDash: [2],
              borderDashOffset: [2],
              color: "rgba(33, 37, 41, 0.3)",
              zeroLineColor: "rgba(33, 37, 41, 0.3)",
              zeroLineBorderDash: [2],
              zeroLineBorderDashOffset: [2],
            },
          },
        ],

        xAxes: [
          {
            display: true,
            scaleLabel: {
              display: true,
              labelString: "Month",
              fontColor: "gray",
            },
            gridLines: {
              display: true,
              borderDash: [2],
              borderDashOffset: [2],
              color: "rgba(33, 37, 41, 0.3)",
              zeroLineColor: "rgba(33, 37, 41, 0.3)",
              zeroLineBorderDash: [2],
              zeroLineBorderDashOffset: [2],
            },
          },
        ],

        yAxes: [
          {
            display: true,
            scaleLabel: {
              display: true,
              labelString: "Value",
              fontColor: "gray",
            },
            gridLines: {
              borderDash: [3],
              borderDashOffset: [3],
              drawBorder: false,
              color: "rgba(33, 37, 41, 0.2)",
              zeroLineColor: "rgba(33, 37, 41, 0.15)",
              zeroLineBorderDash: [2],
              zeroLineBorderDashOffset: [2],
            },
          },
        ],
      },
    },
  };
  var ctx = document
    .getElementById("user-register-line-chart")
    .getContext("2d");
  window.myLine = new Chart(ctx, config);
});
</script>

<template>
  <div
    class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white border"
  >
    <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
      <div class="flex flex-wrap items-center">
        <div class="relative w-full max-w-full flex-grow flex-1">
          <h6 class="uppercase text-blueGray-400 mb-1 text-xs font-semibold">
            Overview
          </h6>
          <h2 class="text-xl font-semibold text-blueGray-700">
            Total Register User
          </h2>
        </div>
      </div>
    </div>
    <div class="p-4 flex-auto">
      <!-- Chart -->
      <div class="relative h-350-px">
        <canvas id="user-register-line-chart"></canvas>
      </div>
    </div>
  </div>
</template>
