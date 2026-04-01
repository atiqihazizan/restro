<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kitchen Display System</title>
    <link rel="stylesheet" href="{{ URL::asset('css/ui-kit/mdb.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/fontawesome/css/all.min.css') }}">
    <style>
        body {
            background: #1a1a1a;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .kds-header {
            background: #2d2d2d;
            padding: 1rem 2rem;
            border-bottom: 3px solid #4CAF50;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .kds-header h1 {
            margin: 0;
            font-size: 2rem;
            color: #4CAF50;
        }
        .kds-time {
            font-size: 1.5rem;
            color: #fff;
        }
        .kds-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
            height: calc(100vh - 100px);
            overflow-y: auto;
        }
        .order-card {
            background: #2d2d2d;
            border-radius: 12px;
            padding: 1.5rem;
            border: 3px solid #4CAF50;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .order-card.urgent {
            border-color: #ff5252;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { border-color: #ff5252; }
            50% { border-color: #ff8a80; }
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #444;
        }
        .table-name {
            font-size: 2rem;
            font-weight: bold;
            color: #4CAF50;
        }
        .order-time {
            font-size: 1rem;
            color: #aaa;
        }
        .order-items {
            margin: 1rem 0;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #444;
            font-size: 1.1rem;
        }
        .item-name {
            flex: 1;
            font-weight: 500;
        }
        .item-qty {
            font-weight: bold;
            color: #4CAF50;
            margin-left: 1rem;
        }
        .order-footer {
            margin-top: 1.5rem;
            display: flex;
            gap: 1rem;
        }
        .btn-done {
            flex: 1;
            padding: 1rem;
            font-size: 1.2rem;
            font-weight: bold;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-done:hover {
            background: #45a049;
            transform: scale(1.05);
        }
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
            font-size: 1.5rem;
        }
        .connection-status {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .connection-status.connected {
            background: #4CAF50;
            box-shadow: 0 0 8px #4CAF50;
        }
        .connection-status.disconnected {
            background: #ff5252;
        }
    </style>
</head>
<body>
    <div class="kds-header">
        <h1><i class="fas fa-utensils"></i> Kitchen Display</h1>
        <div class="kds-time">
            <span class="connection-status disconnected" id="mqtt-status"></span>
            <span id="current-time"></span>
        </div>
    </div>
    
    <div class="kds-container" id="orders-container">
        <div class="empty-state">
            <i class="fas fa-clock" style="font-size: 4rem; margin-bottom: 1rem; display: block;"></i>
            Waiting for orders...
        </div>
    </div>

    <script src="{{ URL::asset('js/plugin/moment.min.js') }}"></script>
    <script src="{{ URL::asset('js/mqttws31.js') }}"></script>
    <script>
        const APP_URL = '{{ url('/') }}/';
        const MQTT_HOST = 'localhost';
        const MQTT_PORT = 1884;
        const MQTT_TOPIC = 'kitchen/orders';
        
        let mqttClient = null;
        let activeOrders = {};

        function updateTime() {
            document.getElementById('current-time').textContent = moment().format('HH:mm:ss');
        }
        setInterval(updateTime, 1000);
        updateTime();

        function connectMQTT() {
            try {
                const clientId = 'kitchen_' + Math.random().toString(16).substr(2, 8);
                mqttClient = new Paho.MQTT.Client(MQTT_HOST, MQTT_PORT, clientId);
                
                mqttClient.onConnectionLost = function(response) {
                    console.log('MQTT Connection Lost:', response.errorMessage);
                    document.getElementById('mqtt-status').className = 'connection-status disconnected';
                    setTimeout(connectMQTT, 5000);
                };
                
                mqttClient.onMessageArrived = function(message) {
                    console.log('MQTT Message:', message.payloadString);
                    try {
                        const data = JSON.parse(message.payloadString);
                        handleOrderUpdate(data);
                    } catch (e) {
                        console.error('Parse error:', e);
                    }
                };
                
                mqttClient.connect({
                    onSuccess: function() {
                        console.log('MQTT Connected');
                        document.getElementById('mqtt-status').className = 'connection-status connected';
                        mqttClient.subscribe(MQTT_TOPIC);
                        loadActiveOrders();
                    },
                    onFailure: function(err) {
                        console.error('MQTT Connection Failed:', err);
                        document.getElementById('mqtt-status').className = 'connection-status disconnected';
                        setTimeout(connectMQTT, 5000);
                    }
                });
            } catch (e) {
                console.error('MQTT Init Error:', e);
                document.getElementById('mqtt-status').className = 'connection-status disconnected';
            }
        }

        function loadActiveOrders() {
            fetch(APP_URL + 'ordering/?getpos=true')
                .then(res => res.json())
                .then(data => {
                    const tables = data.table || [];
                    tables.forEach(table => {
                        if (table.order_id > 0) {
                            loadOrderDetails(table.order_id, table.name);
                        }
                    });
                })
                .catch(err => console.error('Load orders error:', err));
        }

        function loadOrderDetails(billId, tableName) {
            fetch(APP_URL + 'counter/' + billId + '/pos')
                .then(res => res.json())
                .then(data => {
                    if (data.item && data.item.length > 0) {
                        activeOrders[billId] = {
                            id: billId,
                            table: tableName,
                            items: data.item,
                            time: moment().format('HH:mm')
                        };
                        renderOrders();
                    }
                })
                .catch(err => console.error('Load order details error:', err));
        }

        function handleOrderUpdate(data) {
            if (data.action === 'new_order' || data.action === 'update_order') {
                activeOrders[data.bill_id] = {
                    id: data.bill_id,
                    table: data.table_name,
                    items: data.items || [],
                    time: moment().format('HH:mm')
                };
                renderOrders();
            } else if (data.action === 'order_paid') {
                delete activeOrders[data.bill_id];
                renderOrders();
            }
        }

        function renderOrders() {
            const container = document.getElementById('orders-container');
            const orders = Object.values(activeOrders);
            
            if (orders.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-clock" style="font-size: 4rem; margin-bottom: 1rem; display: block;"></i>
                        Waiting for orders...
                    </div>`;
                return;
            }
            
            container.innerHTML = orders.map(order => {
                const elapsed = moment().diff(moment(order.time, 'HH:mm'), 'minutes');
                const isUrgent = elapsed > 15;
                
                return `
                    <div class="order-card ${isUrgent ? 'urgent' : ''}" data-order-id="${order.id}">
                        <div class="order-header">
                            <div class="table-name">${order.table}</div>
                            <div class="order-time">${order.time}</div>
                        </div>
                        <div class="order-items">
                            ${order.items.map(item => `
                                <div class="order-item">
                                    <span class="item-name">${item.name}</span>
                                    <span class="item-qty">x${item.qty}</span>
                                </div>
                            `).join('')}
                        </div>
                        <div class="order-footer">
                            <button class="btn-done" onclick="markOrderDone(${order.id})">
                                <i class="fas fa-check"></i> DONE
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function markOrderDone(orderId) {
            if (confirm('Mark this order as done?')) {
                delete activeOrders[orderId];
                renderOrders();
            }
        }

        connectMQTT();
        setInterval(() => renderOrders(), 60000);
    </script>
</body>
</html>
