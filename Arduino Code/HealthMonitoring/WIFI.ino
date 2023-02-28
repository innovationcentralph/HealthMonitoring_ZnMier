byte reconnectCount = 0;


void initWiFi() {
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi ..");

  
  display.clearDisplay();
  displayMessage("Connecting to WiFi", 1);
  
  while (WiFi.status() != WL_CONNECTED) {
    reconnectCount++;
    if(reconnectCount > RECONN_LIMIT){
      ESP.restart();
    }
    Serial.print('.');
    delay(1000);
  }
  Serial.println(WiFi.localIP());

  display.clearDisplay();
  displayMessage("   Connected!", 1);
  
  
}

void sendDataToWeb(){
  if(WiFi.status() == WL_CONNECTED){
    client.setInsecure();//skip verification
    if (!client.connect(server, 443))
      Serial.println("Connection failed!");
    else {
      Serial.println("Connected to server!");
      // Make a HTTP request:
      String URL = "GET https://mactechph.com/healthmonitoring/resources/data/sensorlog.php?id=ABC123&hr=" + String(currentPatientReading.hr) + "&o2=" + String(currentPatientReading.spo2) + "&bp1=" + String(currentPatientReading.dia) + "&bp2=" + String(currentPatientReading.sys) + " HTTP/1.0";
      client.println(URL);
      client.println("Host: www.mactechph.com");
      client.println("Connection: close");
      client.println();
  
      while (client.connected()) {
        String line = client.readStringUntil('\n');
        if (line == "\r") {
          Serial.println("headers received");
          break;
        }
      }
      // if there are incoming bytes available
      // from the server, read them and print them:
      while (client.available()) {
        char c = client.read();
        Serial.write(c);
      }
  
      client.stop();
    }
  }
}
