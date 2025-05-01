document.addEventListener('DOMContentLoaded', function () {
  const menuToggle = document.querySelector('.menu-toggle');
  const navbar = document.querySelector('.navbar');

  // Toggle the mobile menu
  menuToggle.addEventListener('click', function () {
    navbar.classList.toggle('active');
  });

  // AJAX functions for each header navigation link
  window.loadHomePage = function () {
    $.ajax({
      url: "../user/landing_page", // Removed .php
      method: 'GET',
      success: function (response) {
        document.open();
        document.write(response);
        document.close();
      },
      error: function (xhr, status, error) {
        console.error('Error loading Home page:', error);
        alert('Failed to load Home page. Please try again.');
      }
    });
  };

  window.loadVolunteerPage = function () {
    $.ajax({
      url: "../user/volunteer", // Removed .php
      method: 'GET',
      success: function (response) {
        document.open();
        document.write(response);
        document.close();
      },
      error: function (xhr, status, error) {
        console.error('Error loading Volunteer page:', error);
        alert('Failed to load Volunteer page. Please try again.');
      }
    });
  };

  window.loadAboutUsPage = function () {
    $.ajax({
      url: "../user/aboutus", // Removed .php
      method: 'GET',
      success: function (response) {
        document.open();
        document.write(response);
        document.close();
      },
      error: function (xhr, status, error) {
        console.error('Error loading About Us page:', error);
        alert('Failed to load About Us page. Please try again.');
      }
    });
  };

  window.loadRegistrationPage = function () {
    $.ajax({
      url: "../user/Registrationmadrasa", // Removed .php
      method: 'GET',
      success: function (response) {
        document.open();
        document.write(response);
        document.close();
      },
      error: function (xhr, status, error) {
        console.error('Error loading Registration page:', error);
        alert('Failed to load Registration page. Please try again.');
      }
    });
  };

  window.loadTransparencyPage = function () {
    $.ajax({
      url: "../user/transparencyreport", // Removed .php
      method: 'GET',
      success: function (response) {
        document.open();
        document.write(response);
        document.close();
      },
      error: function (xhr, status, error) {
        console.error('Error loading Transparency page:', error);
        alert('Failed to load Transparency page. Please try again.');
      }
    });
  };

  window.loadCalendarPage = function () {
    $.ajax({
      url: "../user/calendar", // Removed .php
      method: 'GET',
      success: function (response) {
        document.open();
        document.write(response);
        document.close();
      },
      error: function (xhr, status, error) {
        console.error('Error loading Calendar page:', error);
        alert('Failed to load Calendar page. Please try again.');
      }
    });
  };

  window.loadFAQsPage = function () {
    $.ajax({
      url: "../user/faqs", // Removed .php
      method: 'GET',
      success: function (response) {
        document.open();
        document.write(response);
        document.close();
      },
      error: function (xhr, status, error) {
        console.error('Error loading FAQs page:', error);
        alert('Failed to load FAQs page. Please try again.');
      }
    });
  };

  // Attach event listeners to header navigation links
  document.querySelector('.nav-links a[href$="landing_page"]').addEventListener('click', function (event) {
    event.preventDefault();
    loadHomePage();
  });

  document.querySelector('.nav-links a[href$="volunteer"]').addEventListener('click', function (event) {
    event.preventDefault();
    loadVolunteerPage();
  });

  document.querySelector('.nav-links a[href$="aboutus"]').addEventListener('click', function (event) {
    event.preventDefault();
    loadAboutUsPage();
  });

  document.querySelector('.nav-links a[href$="Bylaws"]').addEventListener('click', function (event) {
    event.preventDefault();
    loadRegistrationPage();
  });

  document.querySelector('.nav-links a[href$="transparencyreport"]').addEventListener('click', function (event) {
    event.preventDefault();
    loadTransparencyPage();
  });

  document.querySelector('.nav-links a[href$="calendar"]').addEventListener('click', function (event) {
    event.preventDefault();
    loadCalendarPage();
  });

  document.querySelector('.nav-links a[href$="faqs"]').addEventListener('click', function (event) {
    event.preventDefault();
    loadFAQsPage();
  });
});