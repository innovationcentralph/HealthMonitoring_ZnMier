//Libraries
#include <Wire.h>
#include "max32664.h"
#include <WiFiClientSecure.h>

#include <Adafruit_GFX.h>        
#include <Adafruit_SSD1306.h>

//Constants
const char * ssid     = "SKYFiber_MESH_4DF4";
const char * password = "531123942";
const char*  server   = "www.mactechph.com";  
const byte RECONN_LIMIT = 20;

static const unsigned char PROGMEM logo2_bmp[] =
{ 0x03, 0xC0, 0xF0, 0x06, 0x71, 0x8C, 0x0C, 0x1B, 0x06, 0x18, 0x0E, 0x02, 0x10, 0x0C, 0x03, 0x10,             
0x04, 0x01, 0x10, 0x04, 0x01, 0x10, 0x40, 0x01, 0x10, 0x40, 0x01, 0x10, 0xC0, 0x03, 0x08, 0x88,
0x02, 0x08, 0xB8, 0x04, 0xFF, 0x37, 0x08, 0x01, 0x30, 0x18, 0x01, 0x90, 0x30, 0x00, 0xC0, 0x60,
0x00, 0x60, 0xC0, 0x00, 0x31, 0x80, 0x00, 0x1B, 0x00, 0x00, 0x0E, 0x00, 0x00, 0x04, 0x00,  };

static const unsigned char PROGMEM logo3_bmp[] =
{ 0x01, 0xF0, 0x0F, 0x80, 0x06, 0x1C, 0x38, 0x60, 0x18, 0x06, 0x60, 0x18, 0x10, 0x01, 0x80, 0x08,
0x20, 0x01, 0x80, 0x04, 0x40, 0x00, 0x00, 0x02, 0x40, 0x00, 0x00, 0x02, 0xC0, 0x00, 0x08, 0x03,
0x80, 0x00, 0x08, 0x01, 0x80, 0x00, 0x18, 0x01, 0x80, 0x00, 0x1C, 0x01, 0x80, 0x00, 0x14, 0x00,
0x80, 0x00, 0x14, 0x00, 0x80, 0x00, 0x14, 0x00, 0x40, 0x10, 0x12, 0x00, 0x40, 0x10, 0x12, 0x00,
0x7E, 0x1F, 0x23, 0xFE, 0x03, 0x31, 0xA0, 0x04, 0x01, 0xA0, 0xA0, 0x0C, 0x00, 0xA0, 0xA0, 0x08,
0x00, 0x60, 0xE0, 0x10, 0x00, 0x20, 0x60, 0x20, 0x06, 0x00, 0x40, 0x60, 0x03, 0x00, 0x40, 0xC0,
0x01, 0x80, 0x01, 0x80, 0x00, 0xC0, 0x03, 0x00, 0x00, 0x60, 0x06, 0x00, 0x00, 0x30, 0x0C, 0x00,
0x00, 0x08, 0x10, 0x00, 0x00, 0x06, 0x60, 0x00, 0x00, 0x03, 0xC0, 0x00, 0x00, 0x01, 0x80, 0x00  };


struct Patient{
  float hr = 0;
  float spo2 = 0;
  int sys = 0;
  int dia = 0;
};


//Pin Definitions
#define RESET_PIN 04
#define MFIO_PIN 02
#define PROGRESS_PIN 19
#define RAWDATA_BUFFLEN 250
#define START_BUTTON 14   

 
//OLED Paramas
#define SCREEN_WIDTH  128 
#define SCREEN_HEIGHT 32 
#define OLED_RESET    -1 

//Instance Creation
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET); //Declaring the display name (display)
max32664 MAX32664(RESET_PIN, MFIO_PIN, PROGRESS_PIN, RAWDATA_BUFFLEN);
WiFiClientSecure client;
Patient currentPatientReading;
Patient previousPatientReading;

//Globals
byte samplingState = 0;
byte validReadingCounter = 0;

#define BUTTON_PRESS_MODE 1
#define CALIBRATION_MODE  2
#define SCANNING_MODE     3

byte mode = 0;

void setup() {

  Serial.begin(57600);

  display.begin(SSD1306_SWITCHCAPVCC, 0x3C); //Start the OLED display
  display.display();
   

  pinMode(PROGRESS_PIN, OUTPUT);

  Wire.begin();

  initWiFi();

  loadAlgomodeParameters();

  int result = MAX32664.hubBegin();
  if (result == CMD_SUCCESS){
    Serial.println("Sensor Reading Begin!");
  }else{
    while(1){
      Serial.println("Could not communicate with the sensor! please make proper connections");
      delay(5000);
    }
  }

   displayMessage("   Press Start!", 1);

   mode = BUTTON_PRESS_MODE;

  //Serial.println("Initializing Calibration");
  //initCalibration();
}
bool btnState = 0;
bool startScan = false;
unsigned long int pressMillis = 0;
unsigned long int releaseMillis = 0;
bool isScanning = false;

bool btnVal;
void loop() {

  

  switch(mode){
    case BUTTON_PRESS_MODE:

      readButtons();
      break;

    case CALIBRATION_MODE:
      Serial.println("Long Press Detected Start Calibration");
            
      displayMessage("  Calibrating...", 1);
      initCalibration();

      displayMessage("Calibration Done!", 1);
      delay(1000);
      displayMessage("   Press Start!", 1);

      mode = BUTTON_PRESS_MODE;
      break;

    case SCANNING_MODE:
      displayMessage(" Reading Vitals", 1);
      uint8_t num_samples = MAX32664.readSamples();
      //Serial.println(". ");

      if(num_samples){
        isScanning = true;
        Serial.print("sys = ");
        Serial.print(MAX32664.max32664Output.sys);
        Serial.print(", dia = ");
        Serial.print(MAX32664.max32664Output.dia);
        Serial.print(", hr = ");
        Serial.print(MAX32664.max32664Output.hr);
        Serial.print(" spo2 = ");
        Serial.println(MAX32664.max32664Output.spo2);
        digitalWrite(PROGRESS_PIN, HIGH);
        delay(20);
        digitalWrite(PROGRESS_PIN, LOW);

        if(MAX32664.max32664Output.sys != 0 && MAX32664.max32664Output.dia != 0 && MAX32664.max32664Output.hr != 0 && MAX32664.max32664Output.spo2 != 0){
          previousPatientReading.hr = currentPatientReading.hr;
          previousPatientReading.spo2 = currentPatientReading.spo2;
          previousPatientReading.sys = currentPatientReading.sys;
          previousPatientReading.dia = currentPatientReading.dia;
          
          currentPatientReading.hr = MAX32664.max32664Output.hr;
          currentPatientReading.spo2 = MAX32664.max32664Output.spo2;
          currentPatientReading.sys = MAX32664.max32664Output.sys;
          currentPatientReading.dia = MAX32664.max32664Output.dia;

          if(previousPatientReading.hr == currentPatientReading.hr && previousPatientReading.spo2 == currentPatientReading.spo2 && previousPatientReading.sys == currentPatientReading.sys && previousPatientReading.dia == currentPatientReading.dia){
            
            displayMessage("  Done Reading   ", 1);
            sendDataToWeb();
            //displayMessage("   Press Start!", 1);

             display.clearDisplay();
             display.setTextSize(1);                    
             display.setTextColor(WHITE);             
             display.setCursor(15,0);                
             display.println("HR: " + String(currentPatientReading.hr));
             display.setCursor(15,12);                
             display.println("O2: " + String(currentPatientReading.spo2));    
             display.setCursor(15,20);                
             display.println("BP: "+ String(currentPatientReading.sys) + "/" +String(currentPatientReading.dia)); 
             display.display();

             delay(3000);
             mode = BUTTON_PRESS_MODE;
          }
        }
      }
      else{
        //displayMessage("Needs Calibration", 1);
      }
      readButtons();
      break;
      
  }

}
