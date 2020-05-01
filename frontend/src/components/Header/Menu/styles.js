import styled from 'styled-components';
import { darken } from 'polished';

export const Navigation = styled.div`
  display: block;
  position: relative;
  z-index: 1;
  -webkit-user-select: none;
  user-select: none;
  cursor: default;

  a {
    text-decoration: none;
  }

  input {
    display: block;
    width: 40px;
    height: 32px;
    position: absolute;
    top: -7px;
    left: -5px;
    
    cursor: pointer;
    
    opacity: 0;
    z-index: 2;
    
    -webkit-touch-callout: none;
  }

  span {
    display: block;
    width: 33px;
    height: 5px;
    margin-bottom: 5px;
    position: relative;
    
    background: #232323;
    border-radius: 3px;
    
    z-index: 1;
    
    transform-origin: 5px 0;
    
    transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
                background 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
                opacity 0.55s ease;
                
    :first-child {
        transform-origin: 0 0;
    }
    
    :nth-last-child(2) {
      transform-origin: 0 100%;
    }
  }

  input:checked ~ span {
    opacity: 1;
    transform: rotate(45deg) translate(0, 2px);
    background: #232323;
  }
  
  input:checked ~ span:nth-last-child(3) {
    opacity: 0;
    transform: rotate(0deg) scale(0.2, 0.2);
  }
  
  input:checked ~ span:nth-last-child(2) {
    transform: rotate(-45deg) translate(0);
  }
  
  input:not(:checked) ~ .badge {
    content: "";
    display: ${props => props.unread ? 'block' : 'none'};
    position: absolute;
    z-index: 3;
    margin: -4px;
    width: 10px;
    height: 10px;
    background: #ff892e;
    border-radius: 50%;
    transition: 200ms;
  }
  
  #menuToggle input:checked ~ ul {
    transform: none;
  }

  #menu {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    position: absolute;
    width: 300px;
    margin: -100px 0 0 -50px;
    padding: 125px 50px 50px;
    
    background: #fff;
    list-style-type: none;
    -webkit-font-smoothing: antialiased;
    
    transform-origin: 0 0;
    transform: translate(0, -100%);
    
    transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0);
    
    li {
      padding: 10px 0;
      font-size: 22px;
      color: #232323;
      transition: color 0.3s ease;
      display: inline-block;
      
      :hover
      {
        color: #8354b3;
      }
    }
    
    .last {
      color: #ff6347;
      
      :hover {
        color: ${darken(0.25, '#ff6347')};
      }
    }
  }
`
