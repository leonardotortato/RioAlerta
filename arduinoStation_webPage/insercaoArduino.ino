
#include <SPI.h>
#include <Ethernet.h>
#include <Wire.h>
#include <VL53L0X.h>

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED }; // Endereço MAC do Arduino
byte server[] = { 192, 168, 0, 2 };
IPAddress ip(192, 168, 0, 3);
IPAddress gateway(192, 168, 0, 2); // Define o gateway
IPAddress subnet(255, 255, 255, 0); // Define a máscara de rede

EthernetClient client;

VL53L0X sensor;

int valorSensor = 0;
int dist_old = 0;
int buzzer = 3;
int altura = 0;
unsigned long timeout = 0;

void setup() {
  Serial.begin(9600);
  Ethernet.begin(mac, ip, gateway, subnet);
  pinMode(5, OUTPUT);
  pinMode(6, OUTPUT);
  pinMode(7, OUTPUT);
  pinMode(buzzer, OUTPUT);
  Wire.begin();
  sensor.init();
  sensor.setTimeout(500);
  delay(1000);
}

void loop() {
  valorSensor = sensor.readRangeSingleMillimeters();
  filtrar_sinal();
  altura = 120 -  valorSensor;
  if (altura < 0){
    altura = 0;
  }
  Serial.println(valorSensor);
  Serial.println(altura);
  leds();

  if (client.connect(server, 80)) {
    Serial.println("Conectado ao servidor");

    String relatorio;

    if (altura < 30) {
      relatorio = "Baixo";
    } else if (altura >= 30 && altura < 45) {
      relatorio = "Moderado";
    } else {
      relatorio = "Alto";
    }

    // Construir a URL com ambos os parâmetros
    String requestURL = "GET /inserir.php?sensor=" + String(altura) + "&relatorio=" + relatorio + " HTTP/1.1";
    client.println(requestURL);
    client.println("Host: 192.168.0.2");
    client.println();
    delay(2000);
    while (client.available()) {
      char c = client.read();
      Serial.write(c);
    }

    client.stop(); // Fecha a conexão após a requisição
    Serial.println("Conexão encerrada");
  }
  else {
    Serial.println("Falha na conexão com o servidor");
  }

  delay(5000); // Aguardar 5 segundos antes de enviar o próximo dado
}


void filtrar_sinal()
{

  if (valorSensor > 8000 && ((millis() - timeout) < 1000))
  {
    valorSensor = dist_old;
  }
  else
  {
    dist_old = valorSensor;
    timeout = millis();
  }
}

void leds()
{
  if (altura < 30) { //verde
    noTone(buzzer);
    digitalWrite(5, HIGH);
    digitalWrite(6, LOW);
    digitalWrite(7, LOW);
  } else if (altura >= 30 && altura < 45) { //amarelo
    noTone(buzzer);
    digitalWrite(5, LOW);
    digitalWrite(6, HIGH);
    digitalWrite(7, LOW);
  } else { //vermelho
    tone(buzzer, 1500);
    digitalWrite(5, LOW);
    digitalWrite(6, LOW);
    digitalWrite(7, HIGH);
  }
}
