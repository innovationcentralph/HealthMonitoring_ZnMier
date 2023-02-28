void readButtons(){
   btnVal = digitalRead(START_BUTTON);
   //Serial.println(btnVal);

      if(btnState == 0){
        if(btnVal == 0){
          btnState = 1;
          pressMillis = millis();
          delay(50);
        }
      }
    
      else if(btnState == 1){
        if(btnVal == 1){
          releaseMillis = millis();
          delay(100);
    
          if(releaseMillis - pressMillis > 5000){
            mode = CALIBRATION_MODE;
          }
          else if(releaseMillis - pressMillis > 2000){
            mode = SCANNING_MODE;
          }
          else if(releaseMillis - pressMillis > 500){
            
            displayMessage("   Press Start!", 1);
            mode = BUTTON_PRESS_MODE; 
          }
          btnState = 0;
          delay(100);
        }
      }
}
