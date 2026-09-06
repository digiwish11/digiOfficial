<?php
/* ==================================================================
   DASHBOARD.PHP  (this one file is PHP, not plain HTML)
   ------------------------------------------------------------------
   Recommendation: every other page in this project (index.html,
   signup.html) is plain HTML because they don't need to know who is
   logged in. This page DOES need that — it shows the logged-in
   person's own orders and must block anyone without a session — so
   it has to run through PHP. Start the session, confirm the user is
   logged in, and pull their name for the greeting.
   ================================================================== */
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

$displayName = htmlspecialchars($_SESSION['username'] ?? 'Friend');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digi Wish — Create a Wish</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="topbar">
    <div class="brand">
      <span class="brand-icon">✦</span>
      <span class="brand-text">Digi<span class="brand-accent">Wish</span></span>
    </div>
    <div class="topbar-right">
      <span class="welcome-text">Hi, <?php echo $displayName; ?> 👋</span>
      <button id="themeToggle" class="theme-toggle" type="button" aria-label="Toggle dark and light mode">
        <span class="theme-toggle-icon">🌙</span>
        <span class="theme-toggle-label">Dark mode</span>
      </button>
      <a href="logout.php" class="btn btn-ghost btn-small">Log out</a>
    </div>
  </header>

  <main class="dash-wrap">

    <section class="dash-hero">
      <h1>Let's build your wish 🎉</h1>
      <p>Pick an occasion below, then open <strong>Order Details</strong> to fill in the rest.</p>
    </section>

    <!-- ============================================================
         FESTIVAL / OCCASION SECTION
         Recommendation: each button sets a hidden input
         (#selectedFestival) used by main.js and also submitted
         with the form to submit_order.php. Add more occasions
         by copying a <button> line — no other code changes needed.
    ============================================================= -->
    <section class="festival-section">
      <h2>1. Choose the occasion</h2>
      <div class="festival-grid" id="festivalGrid">
        <button type="button" class="festival-btn" data-festival="Birthday">🎂 Birthday</button>
        <button type="button" class="festival-btn" data-festival="Marriage">💍 Marriage</button>
        <button type="button" class="festival-btn" data-festival="Anniversary">💐 Anniversary</button>
        <button type="button" class="festival-btn" data-festival="Proposal">❤️ Proposal</button>
        <button type="button" class="festival-btn" data-festival="Farewell">👋 Farewell</button>
        <button type="button" class="festival-btn" data-festival="Diwali">🪔 Diwali</button>
        <button type="button" class="festival-btn" data-festival="Pongal">🌾 Pongal</button>
        <button type="button" class="festival-btn" data-festival="Raksha Bandhan">🎗️ Raksha Bandhan</button>
        <button type="button" class="festival-btn" data-festival="Ramzan">🌙 Ramzan</button>
        <button type="button" class="festival-btn" data-festival="Christmas">🎄 Christmas</button>
        <button type="button" class="festival-btn" data-festival="New Year">🎇 New Year</button>
        <button type="button" class="festival-btn" data-festival="New Born">👶 New Born</button>
        <button type="button" class="festival-btn" data-festival="Other">✨ Other</button>
      </div>
      <p class="festival-selected-hint">Selected occasion: <span id="festivalSelectedLabel">None yet</span></p>
    </section>

    <!-- ============================================================
         DETAILS BUTTON + FORM
         Recommendation: clicking "Order Details" slides this form
         open (see main.js -> toggleDetails()). All fields here are
         submitted together to submit_order.php, which inserts
         one row into the `orders` table per submission.
    ============================================================= -->
    <section class="details-section">
      <button type="button" id="detailsToggleBtn" class="btn btn-primary btn-large">
        📝 Order Details
      </button>

      <div id="detailsMessage" class="form-message" hidden></div>

      <form id="orderForm" action="submit_order.php" method="POST" class="details-form" hidden>

        <input type="hidden" name="festival" id="festivalInput" value="">

        <div class="form-grid">

          <div class="field">
            <label for="recipientName">Wish for (name)</label>
            <input type="text" id="recipientName" name="recipientName" placeholder="e.g. Magilan" required>
          </div>

          <div class="field">
            <label for="wishType">Wish type</label>
            <input type="text" id="wishType" name="wishType" placeholder="e.g. Birthday Wish">
          </div>

          <div class="field">
            <label for="dob">Date of birth</label>
            <input type="date" id="dob" name="dob">
          </div>

          <div class="field field-full">
            <label for="content">Content / message</label>
            <textarea id="content" name="content" rows="4" placeholder="Write what you'd like the wish to say..."></textarea>
          </div>

          <div class="field field-full">
            <label for="extra">Add extra (optional)</label>
            <input type="text" id="extra" name="extra" placeholder="e.g. Add a family photo, mention our nickname 'Mangoes'">
          </div>

          <!-- Media requirements: yes / no dropdowns as requested -->
          <div class="field">
            <label for="needImage">Need image?</label>
            <select id="needImage" name="needImage">
              <option value="No">No</option>
              <option value="Yes">Yes</option>
            </select>
          </div>

          <div class="field">
            <label for="needVideo">Need video?</label>
            <select id="needVideo" name="needVideo">
              <option value="No">No</option>
              <option value="Yes">Yes</option>
            </select>
          </div>

          <div class="field">
            <label for="needAudio">Need audio?</label>
            <select id="needAudio" name="needAudio">
              <option value="No">No</option>
              <option value="Yes">Yes</option>
            </select>
          </div>

          <div class="field field-full">
            <label for="songDetails">Song details</label>
            <textarea id="songDetails" name="songDetails" rows="2" placeholder="e.g. Song name, singer, or a link (fill in if audio is needed)"></textarea>
          </div>

          <div class="field">
            <label for="mobile">Contact mobile number</label>
            <input type="tel" id="mobile" name="mobile" placeholder="e.g. 9876543210" pattern="[0-9]{10}" required>
          </div>

          <div class="field">
            <label for="email">Contact email</label>
            <input type="email" id="email" name="email" placeholder="e.g. magilan@gmail.com" required>
          </div>

          <div class="field">
            <label for="orderDate">Order date</label>
            <input type="date" id="orderDate" name="orderDate" required>
          </div>

          <div class="field">
            <label for="deliveryDate">Delivery date</label>
            <input type="date" id="deliveryDate" name="deliveryDate" required>
          </div>

        </div>

        <button type="submit" class="btn btn-primary btn-block btn-large">Submit order</button>
      </form>
    </section>

  </main>

  <footer class="site-footer">
    <p>&copy; 2026 Digi Wish. Handcrafted wishes, delivered on time.</p>
  </footer>

  <script src="theme.js"></script>
  <script src="main.js"></script>
</body>
</html>
