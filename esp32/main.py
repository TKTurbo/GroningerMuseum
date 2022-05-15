
import bluetooth
from machine import Pin, Timer
from time import sleep_ms

class Ble():
    def __init__(self, name):
        self.name = name
        self.led = Pin(2, Pin.OUT)

        self.ble = bluetooth.BLE()
        self.ble.active(True)

        self.timer1 = Timer(0)
        self.timer2 = Timer(1)

        self.disconnected()
        self.ble.irq(self._irq)
        self.register()
        self.advertise()
    
    def _irq(self, event, data):
        if event == 1:
            print("connected test")
            self.connected()

        elif event == 2:
            print("disconnected test")
            self.disconnected()
        
        elif event == 3:
            print("message test")
            buffer = self.ble.gatts_read(self.rx)
            message = buffer.decode('UTF-8')
            print(message)

            if message == 'led':
                self.led.value(not self.led.value())
    
    def connected(self):
    
        self.timer1.deinit()
        self.timer2.deinit()


    def disconnected(self):
        
        self.timer1.init(period=1000, mode=Timer.PERIODIC, callback=lambda t: self.led(1))
        sleep_ms(200)
        self.timer2.init(period=1000, mode=Timer.PERIODIC, callback=lambda t: self.led(0))

    def register(self):
        
        # Nordic UART Service (NUS)
        NUS_UUID = '6E400001-B5A3-F393-E0A9-E50E24DCCA9E'
        RX_UUID = '6E400002-B5A3-F393-E0A9-E50E24DCCA9E'
        TX_UUID = '6E400003-B5A3-F393-E0A9-E50E24DCCA9E'
            
        BLE_NUS = bluetooth.UUID(NUS_UUID)
        BLE_RX = (bluetooth.UUID(RX_UUID), bluetooth.FLAG_WRITE)
        BLE_TX = (bluetooth.UUID(TX_UUID), bluetooth.FLAG_NOTIFY)
            
        BLE_UART = (BLE_NUS, (BLE_TX, BLE_RX,))
        SERVICES = (BLE_UART, )
        ((self.tx, self.rx,), ) = self.ble.gatts_register_services(SERVICES)

    def send(self, data):
        self.ble.gatts_notify(0, self.tx, data + '\n')

    def advertise(self):
        name = bytes(self.name, 'UTF-8')
        self.ble.gap_advertise(100, bytearray('\x02\x01\x02') + bytearray((len(name) + 1, 0x09)) + name)

ble = Ble("esp32")