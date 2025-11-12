import ApexCharts from "apexcharts";

const renderOrdersChart = (data) => {
  const options = {
    series: [{ name: "Orders", data: data.values }],
    chart: { type: "bar", height: 260, toolbar: { show: false } },
    plotOptions: { bar: { borderRadius: 6, columnWidth: "50%" } },
    xaxis: {
      categories: data.labels,
      labels: {
        rotate: 0,
        style: {
          fontSize: '12px',
          colors: '#64748b',
        },
      },
      axisTicks: { show: false },
    },
    colors: ["#465fff"],
    dataLabels: { enabled: false },
  };

  const chartEl = document.querySelector("#ordersBarChart");
  chartEl.innerHTML = ""; // Reset biar gak dobel render
  const chart = new ApexCharts(chartEl, options);
  chart.render();
};

const renderTopProductsChart = (products) => {
  if (!products || !products.length) {
    document.querySelector("#topProductsChart").innerHTML = `
      <div class="text-center text-gray-400 text-sm pt-10">No data available</div>
    `;
    return;
  }

  const options = {
    series: products.map(p => p.total),
    labels: products.map(p => p.name),
    chart: { type: "donut", height: 260 },
    legend: { position: "bottom" },
    colors: ["#465fff", "#38bdf8", "#10b981", "#f59e0b", "#ef4444", "#8b5cf6", "#ec4899"],
  };

  const chartEl = document.querySelector("#topProductsChart");
  chartEl.innerHTML = "";
  const chart = new ApexCharts(chartEl, options);
  chart.render();
};

const loadOrdersData = async (range = "week") => {
  try {
    const response = await fetch(`/dashboard/orders-stats?range=${range}`);
    const data = await response.json();
    renderOrdersChart(data);
  } catch (error) {
    console.error("Error loading chart data:", error);
  }
};

const initDashboardCharts = () => {
  const topProducts = window.topProducts || [];
  renderTopProductsChart(topProducts);
  loadOrdersData();

  const filter = document.getElementById("ordersRange");
  if (filter) {
    filter.addEventListener("change", (e) => loadOrdersData(e.target.value));
  }
};

export default initDashboardCharts;