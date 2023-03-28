

// Scripts

window.addEventListener("DOMContentLoaded", (event) => {
  // Toggle the side navigation
  const sidebarToggle = document.body.querySelector("#sidebarToggle");
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", (event) => {
      event.preventDefault();
      document.body.classList.toggle("sb-sidenav-toggled");
      localStorage.setItem(
        "sb|sidebar-toggle",
        document.body.classList.contains("sb-sidenav-toggled")
      );
    });
  }
});



/*

این کد جاوااسکریپت برای تعامل با DOM در صفحات وب است.

با استفاده از window.addEventListener("DOMContentLoaded", (event) => {...}) ، اطمینان حاصل می‌شود که تمام محتویات صفحه وب بارگذاری شده و آماده برای بررسی و تغییر است.

این برنامه یک ایونت لیستنر را برای عنصر دکمه‌ای با id ی sidebarToggle ایجاد می‌کند. وقتی دکمه فشرده شود، این برنامه با استفاده از document.body.classList.toggle("sb-sidenav-toggled") کلاس sb-sidenav-toggled را به بدنه سند اضافه یا حذف می‌کند.

سپس با استفاده از localStorage.setItem، وضعیت دکمه سایدبار (باز یا بسته) ذخیره می‌شود تا در بارگیری بعدی صفحه، وضعیت آن حفظ شود.
*/ 
