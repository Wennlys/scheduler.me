import styled from "styled-components";
import background from "../../../assets/background.jpg";

export const Wrapper = styled.div`
    height: 100%;
    background: linear-gradient(180deg, rgba(255, 228, 120, 0.9) 0%, rgba(232, 195, 109, 0.9) 100%),
        url(${background});
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;

    padding: 0 115px;
`;

export const Nav = styled.div`
    padding-top: 30px;

    nav {
        height: 70px;
        display: flex;
        justify-content: space-between;

        img {
            height: 100%;
        }

        aside {
            display: flex;
            align-items: center;
            font-size: 24px;

            fieldset {
                border: none;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 190px;
                height: 65px;
                margin-left: 22px;
                background: #8354b3;
                color: #fff;
                font-weight: bold;
                box-shadow: 4px 4px rgba(0, 0, 0, 0.25);
            }
        }
    }

    div.container {
        margin-top: 175px;
        max-height: 100%;
        display: flex;

        img {
            min-width: 60%;
            margin-right: -250px;
        }

        span {
            display: flex;
            flex-direction: column;
            margin-top: 100px;

            strong {
                font-size: 64px;
                margin-bottom: 60px;
                text-align: center;
            }

            fieldset {
                border: none;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 415px;
                height: 128px;
                margin-left: 300px;
                background: #8354b3;
                color: #fff;
                font-size: 48px;
                font-weight: 500;
                box-shadow: 4px 4px rgba(0, 0, 0, 0.25);
            }
        }
    }
`;
