<!DOCTYPE html>
<html lang="en">
<head>
<script> 
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-61ZF3YJ4R0');
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Easily coordinate rides for our weekly jam session. Whether you're looking for a ride or offering one, connect with friends and keep the music going!" />
    <title>design yourself</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Option 3: Modern Minimalist Design */
        body {
            background-color: #EAE7DC;
            color: #5D4037;
            font-family: Arial, sans-serif;
        }
        .container {
            background: #FFFFFF;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            background: #FFF8E1;
            color: #5D4037;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #FFD700;
            border: none;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #FFAB91;
        }
        .btn-warning {
            background-color: #F4A261;
            border: none;
            color: white;
        }
        .btn-warning:hover {
            background-color: #E76F51;
        }
        .btn-danger {
            background-color: #E63946;
            border: none;
            color: white;
        }
        .btn-danger:hover {
            background-color: #D62828;
        }
        h1, h2 {
            color: #5D4037;
        }
        .color-picker {
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="#add.php" class="btn btn-primary" id="add-btn">Add Ride <i class="fa fa-plus"></i></a>
            <h1 class="text-center flex-grow-1" id="header-text">Available Rides</h1>
        </div>
        <div id="rides-list">
            <div class="card mb-3" id="ride-card">
                <div class="card-body">
                    <h5 class="card-title">Looking from New York</h5>
                    <p><strong>Name:</strong> John Doe</p>
                    <p><strong>Date:</strong> 2025-02-03</p>
                    <p><strong>Time:</strong> 5:30 PM</p>
                    <p><strong>Contact:</strong> <a href="tel:+123456789">+123456789</a></p>
                    <p><strong>WhatsApp:</strong> <a href="https://wa.me/+123456789" target="_blank">Chat on WhatsApp</a></p>
                    <a href="#edit.php" class="btn btn-warning">Edit</a>
                    <a href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
        
        <!-- Color Pickers -->
        <div class="mt-5 p-3 bg-light rounded">
            <h3>Customize Colors</h3>
            <label>Body Background: <input type="color" class="color-picker" id="body-bg" value="#EAE7DC"></label>
            <label>Container Background: <input type="color" class="color-picker" id="container-bg" value="#FFFFFF"></label>
            <label>Add Button: <input type="color" class="color-picker" id="add-btn-color" value="#FFD700"></label>
            <label>Edit Button: <input type="color" class="color-picker" id="edit-btn" value="#F4A261"></label>
            <label>Delete Button: <input type="color" class="color-picker" id="delete-btn" value="#E63946"></label>
            <label>Text Color: <input type="color" class="color-picker" id="text-color" value="#5D4037"></label>
            <label>Card Background: <input type="color" class="color-picker" id="card-bg" value="#FFF8E1"></label>
            <label>Card Text Color: <input type="color" class="color-picker" id="card-text-color" value="#5D4037"></label>
            <label>Footer Background: <input type="color" class="color-picker" id="footer-bg" value="#f8f9fa"></label>
<label>Footer Text Color: <input type="color" class="color-picker" id="footer-text-color" value="#000000"></label>
<label>Footer Contact Link: <input type="color" class="color-picker" id="footer-contact-link" ></label>
            <button id="copy-colors" class="btn btn-secondary mt-3">Copy Colors</button>
        </div>
    </div>

    <footer class="text-center mt-5 p-3" id="footer">
            Website sponsored by WEB SHADCHAN <h6>(shiya sherman)</h6>
            <a href="#" id="footer-link" target="_blank" class="ms-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" width="20">
            </a>
            <a href="#" id="footer-contact" class="text-decoration-underline"> +1 845-244-1202</a>
        </footer>

    <div class="mt-5 p-3 bg-light rounded">
            <h3>Import Colors</h3>
            <textarea id="color-input" class="form-control" rows="5" placeholder='Paste your color JSON here'></textarea>
            <button id="import-colors" class="btn btn-secondary mt-3">Import Colors</button>
        </div>
    <script>
        document.querySelector('#body-bg').addEventListener('input', (e) => {
            document.body.style.backgroundColor = e.target.value;
        });
        document.querySelector('#container-bg').addEventListener('input', (e) => {
            document.querySelector('.container').style.backgroundColor = e.target.value;
        });
        document.querySelector('#add-btn-color').addEventListener('input', (e) => {
            document.querySelector('#add-btn').style.backgroundColor = e.target.value;
        });
        document.querySelector('#edit-btn').addEventListener('input', (e) => {
            document.querySelectorAll('.btn-warning').forEach(btn => btn.style.backgroundColor = e.target.value);
        });
        document.querySelector('#delete-btn').addEventListener('input', (e) => {
            document.querySelectorAll('.btn-danger').forEach(btn => btn.style.backgroundColor = e.target.value);
        });
        document.querySelector('#text-color').addEventListener('input', (e) => {
            document.querySelector('body').style.color = e.target.value;
            document.querySelector('#header-text').style.color = e.target.value;
        });
        document.querySelector('#card-bg').addEventListener('input', (e) => {
            document.querySelectorAll('.card').forEach(card => card.style.backgroundColor = e.target.value);
        });

        document.querySelector('#card-text-color').addEventListener('input', (e) => {
    document.querySelectorAll('.card').forEach(card => card.style.color = e.target.value);
});
document.querySelector('#footer-bg').addEventListener('input', (e) => {
    document.querySelector('#footer').style.backgroundColor = e.target.value;
});
document.querySelector('#footer-text-color').addEventListener('input', (e) => {
    document.querySelector('#footer').style.color = e.target.value;
});
document.querySelector('#footer-contact-link').addEventListener('input', (e) => {
    document.querySelector('#footer-contact').style.color = e.target.value;
});
 



document.querySelector('#copy-colors').addEventListener('click', () => {
            const colors = {
                bodyBg: document.querySelector('#body-bg').value,
                containerBg: document.querySelector('#container-bg').value,
                addBtn: document.querySelector('#add-btn-color').value,
                editBtn: document.querySelector('#edit-btn').value,
                deleteBtn: document.querySelector('#delete-btn').value,
                textColor: document.querySelector('#text-color').value,
                cardBg: document.querySelector('#card-bg').value,
                cardtextcolor: document.querySelector('#card-text-color').value,
                footerTextColor: document.querySelector('#footer-text-color').value,
                footerBg: document.querySelector('#footer-bg').value,
                footerContactLink: document.querySelector('#footer-contact-link').value
            };
            
            const colorString = JSON.stringify(colors, null, 2);
            navigator.clipboard.writeText(colorString).then(() => { 
                alert('Colors copied to clipboard!');
            }).catch(err => console.error('Failed to copy:', err));
        });




          document.querySelector('#import-colors').addEventListener('click', () => {
            try {
                const colorData = JSON.parse(document.querySelector('#color-input').value);
                if (colorData.bodyBg) document.body.style.backgroundColor = colorData.bodyBg;
                if (colorData.containerBg) document.querySelector('.container').style.backgroundColor = colorData.containerBg;
                if (colorData.addBtn) document.querySelector('#add-btn').style.backgroundColor = colorData.addBtn;
                if (colorData.editBtn) document.querySelectorAll('.btn-warning').forEach(btn => btn.style.backgroundColor = colorData.editBtn);
                if (colorData.deleteBtn) document.querySelectorAll('.btn-danger').forEach(btn => btn.style.backgroundColor = colorData.deleteBtn);
                if (colorData.textColor) document.body.style.color = colorData.textColor;
                if (colorData.cardBg) document.querySelectorAll('.card').forEach(card => card.style.backgroundColor = colorData.cardBg);
                if (colorData.cardtextcolor) document.querySelectorAll('.card').forEach(card => card.style.color = colorData.cardtextcolor);
                if (colorData.footerBg) document.querySelector('#footer').style.backgroundColor = colorData.footerBg;
                if (colorData.footerTextColor) document.querySelector('#footer').style.color = colorData.footerTextColor;
                if (colorData.footerContactLink) document.querySelector('#footer-contact').href = colorData.footerContactLink;
            } catch (error) {
                alert('Invalid JSON format. Please check and try again.');
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
