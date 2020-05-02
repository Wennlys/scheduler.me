import styled from 'styled-components'

export const Container = styled.div`
    background: #fff;
    padding: 0 30px;
    height: 64px;
    
    img[alt="logo"] {
      width: 40px;
      height: 40px;
      display: flex;
      margin: -54px auto;
      cursor: pointer;
    }
`

export const Content = styled.div`
    height: 64px;
    max-width: 900px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    a {
      color: #000;
    }
    
    button {
      border: 0;
      background: none;
    }
    
      img {
        width: 40px;
        height: 40px;
      }
      
      img[alt="menu"] {
        cursor: pointer;
      }
`

export const Profile = styled.div`
      display: flex;
      align-items: center;

      hr {
        height: 50px;
        margin: 0 25px;
      }      
      
      img {
        border-radius: 50%;
      }
`
