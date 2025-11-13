$(document).ready(function () {
  const flashData = document.getElementById("flash-data");
  

  if (flashData) {
  console.log(flashData);

    const type = flashData.dataset.type;
    const message = flashData.dataset.message;

    let bgColor = "bg-info";
    let icon = "fa-info-circle";

    switch (type) {
      case "success":
        bgColor = "bg-success";
        icon = "fa-check-circle";
        break;
      case "error":
        bgColor = "bg-danger";
        icon = "fa-times-circle";
        break;
      case "warning":
        bgColor = "bg-warning";
        icon = "fa-exclamation-triangle";
        break;
    }

    // created a custom toast element
    $(document).Toasts("create", {
      class: bgColor,
      title: "Notification",
      autohide: true,
      delay: 3000,
      body: `<i class="fas ${icon} mr-2"></i> ${message}`,
    });
  }
});
