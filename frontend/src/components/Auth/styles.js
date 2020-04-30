import styled from 'styled-components'
import { lighten, darken } from 'polished'

export const Wrapper = styled.div`
    display: flex;
    justify-content: center;
`

export const Content = styled.div`
    pointer-events: all !important;
    box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.5);
    width: 800px;
    min-height: 500px;
    max-height: 1000px;
    background: #fff;
    position: fixed;
    display: flex;
    flex-direction: column;
    border: 2px solid #000;
        
    span {
      display: flex;
      flex-direction: column;
      justify-content: center;
      
      img[alt="close"] {
        width: 50px;
        height: 50px;
        margin: 10px 10px 0;
        cursor: pointer;
      }
      
      span {
        align-items: center;
        
        img {
          width: 120px;
          height: 120px;
        }
      }
      
      button {
        justify-content: flex-end;
      }
    }
    
    form {
    display: flex;
    flex-direction: column;
    padding: 20px 100px;
    
        span.inputs {
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          margin-top: 20px;
        }
    
        input {
          border: 0;
          background: ${lighten(0.2, '#8354B3')};
          width: 100%;
          padding: 20px;
          color: #000;
          font-size: 20px;
          margin-top: 3px;
        }
        
        input[type='checkbox'] {
          width: 0;
        }
        
        
        label {
          display: flex;
          justify-content: center;
          align-items: center;
          margin: 20px;
          font-weight: bold;
          font-size: 20px;
          color: #000;
          
          input {
            margin-right: 20px;
          }
        }
        
        span {
          color: #f54;
          font-size: 20px;
          font-weight: 500;
        }
        
        span.buttons {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-end;
            height: 100%;
            margin-top: 20px;
            
            button {
              width: 280px;
              height: 80px;
              justify-content: center;
            }
            
            button.purple {
              background: #8354B3;
              color: #fff;
              box-shadow: 4px 4px rgba(0, 0, 0, 0.25);
              
              :hover {
                  background: ${darken(0.05, '#8354B3')};
                  cursor: pointer;
              }
            }
            
            button.green {
              background: #42B367;
              font-weight: bold;
              
              :hover {
                  background: ${darken(0.05, '#42B367')};
                  cursor: pointer;
              }
            }
            
            
        }
        
    }
    
`
