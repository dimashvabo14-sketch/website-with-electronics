<?php include 'header.php'; ?>

<div class="contacts-layout">
    <div class="contacts-info">
        <h1 class="section-title">Свяжитесь с нами</h1>
        <p>Мы поставляем только сертифицированное оборудование для радиосвязи и монтажа.</p>
        
        <ul class="contacts-list">
            <li><strong>Телефон:</strong> 8 (800) 123-45-67</li>
            <li><strong>Email:</strong> info@techradio.local</li>
            <li><strong>Адрес:</strong> г.Минск, Промзона 42, Индустриальный проспект, д. 15</li>
        </ul>
    </div>
    
    <div class="contacts-form">
        <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Сообщение отправлено!');">
            <div class="form-group">
                <label>Ваше имя</label>
                <input type="text" required placeholder="Иван Иванов">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" required placeholder="ivan@example.com">
            </div>
            <div class="form-group">
                <label>Сообщение (укажите номенклатуру)</label>
                <textarea rows="5" required placeholder="Интересует кабель коаксиальный 75 Ом..."></textarea>
            </div>
            <button type="submit" class="btn">Отправить запрос</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>