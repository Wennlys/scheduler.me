import styled from "styled-components";
import { darken } from "polished";

export const Container = styled.div`
    max-width: 450px;
    margin: 10px auto;

    form {
        display: flex;
        flex-direction: column;
        margin-top: 30px;

        input {
            background: rgba(255, 255, 255, 0.5);
            border: 0;
            border-radius: 4px;
            height: 40px;
            color: #000;
            padding: 0 15px;
            margin: 0 0 10px;
            text-align: center;

            &:focus::placeholder {
                color: transparent;
            }

            &::placeholder {
                color: rgba(0, 0, 0);
            }
        }

        hr {
            border: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.4);
            margin: 10px 0 20px;
        }

        button {
            margin: 5px 0 0;
            height: 44px;
            background: #8354b3;
            color: #fff;
            border: 0;
            border-radius: 4px;
            font-size: 16px;
            transition: background 0.2s;

            a {
                color: #fff;
            }

            &:hover {
                background: ${darken(0.05, "#8354B3")};
            }
        }
    }

    > button {
        width: 100%;
        margin: 5px 0 0;
        height: 44px;
        background: #f54;
        color: #fff;
        border: 0;
        border-radius: 4px;
        font-size: 16px;
        transition: background 0.2s;

        a {
            color: #fff;
        }

        &:hover {
            background: ${darken(0.05, "#f55")};
        }
    }
`;
