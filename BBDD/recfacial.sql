-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-03-2025 a las 18:31:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `recfacial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tajuste`
--

CREATE TABLE `tajuste` (
  `ID_AJUSTE` int(11) NOT NULL,
  `NOM_AJUSTE` varchar(20) DEFAULT NULL,
  `VALOR_AJUSTE` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tajuste`
--

INSERT INTO `tajuste` (`ID_AJUSTE`, `NOM_AJUSTE`, `VALOR_AJUSTE`) VALUES
(1, 'MaxLoginRq', '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbio`
--

CREATE TABLE `tbio` (
  `COD_BIO` int(11) NOT NULL,
  `COD_TIPO_BIO` int(11) DEFAULT NULL,
  `DATO_BIO` text DEFAULT NULL,
  `COD_EMPLEADO` int(11) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbio`
--

INSERT INTO `tbio` (`COD_BIO`, `COD_TIPO_BIO`, `DATO_BIO`, `COD_EMPLEADO`, `FEC_ALTA`, `NOM_USUARIO_ALTA`) VALUES
(1, 1, 'hSyzhr4xiQj/io4/K2Hh9jlSbTd4c2FBU2wrOFp0NWhTeDJMblBkOG9aZmplYU95MWlLT201OW52VGxlMDFJbHN4RnEvdzQ1Qm8rM1VZWkRQeituZ2o5VTNQbmRPMk52VzJ6M3Z0cGNhM3lGOVU2WlhDZ1owM2JPeU1vakptaE0ra2tlWTJEYXJ1L0laMlZMb1l1cnM4NGlYTlk5azdldEFBNnUwbXBDSHJtZ0x3cnM3UW9aanQ1azhRcHg5eldFVFlqWGZWMmhuTkJaZFBHeDlydVdHeGdlZVdGTnoxNEFlZmJZNVV2Y3N3MEU5YnBQaHBpb3FFL0o2WmNJS3hzM2lNMXZkVkZhL0xnRlBYdyt2VVV2QXN2WkpTMlpGaHpQTk8wM0dOb0pvMVdkQVNUbHVVbkxUSmJTM1lrRWlidXNVY1NuMEkwOFNvVzA4b0tueGY4SXozRk5YYzZUMTNSeXJnbmM5SFFFdzl3Y0lsbDVFSnZQN2hPdnpBc1Z5NlBXUDUxV3ZPWTBBcVJrYklQQWMzM2dEeHNVeGhBN091UzBqVTdQbHRQamYyYWpmUW44dUpLYkFybkYxK05ISTRuSEx2SDJNVzJoRlZCaTcyUnppRHhEL0xuYmE2Wmt1L1Rkb1hnb01DV0ZUZ3kzSXh5Q2RiYzVKUWdFT3FRTUdKZ3gyWU5rVnBSZXBJNTFhUkdoZ2lmM1JXbVRmU3B5M2hVSmtmenYvT0gzaTVOZGplRkI1UkVZcDB2TnQ2VTNUa210VTYzY0RNVE9hQzkyTUhjb2FmVUFKd2N3MzlmSUhHd0hLbnpPWkxGMmxjajRDQThHcUYraFhVSFNmcllqQ2hUeTZYSUppN3lGOVNmOURwZUpoS2ZDVFFmck9odmNNRlNDZzRHOHdEcCtMTHJLWTM5VFdvMWtOU25vdE9udFQzb3hBSlY2ZzdnVVNqdFdWeE1zZWN0elF1NEl3NVJWeXplK2RHZVNOSHU5NjBibnhXdGhHRHp5ZnNvUHd6VnJjQjd1NjhLbnp4YkFXK2dWaDN4ZzhHbHh1REJES0h3Tk1oYmx2S2xDeUpBcHpIS205VWxndnBhT2ZDU0x5ZHRyOS84Z3c5c1hpQ1RMSWJQVE41M0MxVjJNQU1JdTFhMzNrSEVnVlR2bnMvUW8yblhoVVBNSE1Nd3FodHBHeHAvd2IydWxkOFYrR1BBempvQlpabHlRaWZpMDNCa1FpQTJhWmh2cmFUaTdOV1duKzd3dTNkdWlMejNEWWlzQVJzUFVueTVIQlVCb2E4eHFVa0JhZmhVT0pMbkJUdU1OcnNHQzFnT2lMZXNuZ3ErdWxZSWpBMzN6azhCUkdTM3EvNWsxQTgvMjcxcnQzMENVNHhxSStyMXpHR1QwR09Zc0c4bXRsTi9YTzZYM0pPMUFDeFJiY0NIU0ljZEM5bkdiMzlha1VEUjFGeDg3dWI2NVhLeUhQU0dFcUZTUHc4d3g2YWpXOG42ZW5ReUpXMnRReUtCaGNjbVg0blh1Ni9qaDFtanAyOUplTEgrazdnbDd1YkJoRDNsS0JXcFVhZ25WeHpyU0pnOVFEZjVCeDJrNUpSd1RhdFphTmV5N2Eya1MzWTFIQko3SkF2Y2ovRmtXT3ZjRHcwdC9zZTdNK1ZxR0tBcDZDbmo3b2hORU1obFluZUxHeUFtTEo4eDdqU2FLc0Vid0lPdTdpZXZXM0tLNTZxRlVqM0cxeXdvQzI1Zm5GZlBnblZUSUtwSEJRejNKMlpjWUNKeXhjbXV6eUd1WjZrY1ZJeXI5M0c2cC9BeTBLSjVQODlDZUJpS0pFUkxwa2hFcnJPaDJPTkUrcEdXaU42ZmU0bTRWMW4yU0oyVEJWZFN4NzVpcEVSQmZNOVVldk8rVDRVRTRRUEVDclZrUEltL1JsQVlRZEVFa2xtd01mYzNXbG5xbGJ4bkpzaHRpeVNQWnJxWmp1MC83c3E1eFliQXNLTElaSm5VRzJmTXhVVVZwaENxUTNQam9PakZKQm9zT3lwbjZQWGxJTHRjQWFkQzFpQ3JxUkQ0d1cxT1VWQ24yblE5cU5XcUR6bFZEVlRyb1ZHMTRhOEQ4NWcxU2RBWVVkTytzcGh1YTN4cDlXV0RhbG5qaHJUK29pMFphMlVVeDBEQ2dqcURLTmZWcG5LOVN5c0RpMSs3RHFkZW5Id2pkZ0xUeHNMeitBek93d0FLMzFkNnlJUFJrR2YrWDNmL1NsTDFyWjU3Mms1czJEUkNmRHRTNmVrUXRzL2k3Y2lOQVc0bDZkZk1PbEpVUUlKUXdUQ05HMHNwTzRMeGpHYzJ2bDk5MUR4UEZWK25wdERrQ1RaVG8yTDJGQjIyeHViU0NHZ1lHMmNDU3phcnE3YnFFOTUzWHNwMHYrTEw5djVhQ0FiN1QwUnZ6eDZsL3RDbzlzdHJRamYreHI1amxwZFBsRUNpYlJ5TGRiY1l6Q0h4UWFpeVRZc1VBVnFuRC9CL1pTN2tmUnY3WXREYnFKMG50NElMbGg5NHNadlV6M3pxVW1DdEhBdFZ3b0FUTkp4NTZYQzVid3crc1d3Z3JHWFBXdDNlaGZDUms4ZkhaZnkrV0hoTFVnaHBRR0Rnd0FiZVBYajBweUIzNmxmaUNkNS9ZclNQcmU5WGtFOWZadEdnSWcrYm1WRlRsWm4wVTZyRlVKWlpyNnFVbVk1Tk1MTnVYdG5FZ2ZwQTNzM0J2MVpMYjB0V3RoNDgrNHpDcllrVGFRdlVQNXpkYll4bThBbVdZWmVJaUQ5eW5VbUt0bWprcWtHem1Hem5DenVFNk9aTHhBdW41UHVpbC85U0krcUtjUC9BZXk1d2ZQZXJlRW9IbnVyMzFRRFdXNHd3Vm5Hd0ZpQ200eFRVQ0RMQ2VvbVlSM1NmdWhKcVd3VTZWQlNWZ1JzbC84M3lQcVRDeGU3RnR2M3k0RFErWUxaajQvSDBiZFJZR0Z5eHdwZEVRVTlyWStNWVhwSWtseFdMdlF3bGxJQ3hFZnJhdHp2ZjR0Y25oWGlvVlFZam1pVENxUU96RGU0RzdpY2ZhS29wNlhGUmpDQmRtUENVc2FsdWQ1MUZwaUJqR2pTN2x6U0dmcmE3aUU0a2xweXloOWpJMlowTVlqeHVzcTlmUnNZRkJVU2VDZUZkR2cxZ1BjSzhseUxhdjRxT3VyNDdnY3dxNGtxeFdZRm9BOFdKenhTbDN5dlhjdlpsc0xMazJ5NjhjVmtaT0pXWkcrUTNxOGtWZm1KTGwyaEtUeXJOWm8ya3JTZFVqYzdOUXI4dFlqdU91SWpnTkR5ekpMdFZuMGtMRnhFbE5aWk9UK2Z3MkdTaVhGeCtIWXc0V0RKUzJ3ZHlRb0hBdzVrZXErQzUyQ3lNZGtoUHU2ZkdsQTRVTFRDTTNuMEI3QnJsRW9PeFRORVROTFJIZDNFTjVCekZ2SFZnS3FNZkVwc2dVeFd2UnF6cldjcVRLcCtvbURoK3RlTWZKaDl2dHNqbkJOL3h5Nllod1pGeHVvU3I1bUJlcSt0cVlROTE1dVZxRDNoV1ZURXJIdWtqUVJQRVh1NTZZeVN0TWlnZXo4S1VsQ3o0b2dPVWZVczVPdXl6VEFsV2FqWlVPdWJadUloR0ZQY1QxRHFwMmtNdlNIZlRiS1J4Z0I2bExGVHFEeDlxYzFiQnhPUE5jc3Q4ZUFJdHFSZnhWbGVTQ2R2Zi9IR0I0TVliMGQyUTE2NDVBTkVMR0QxeWtYa1ZCZm8zNHJGa2lPVXZVb0p1eWFTUW9tV3dsbGU5RnpkdHFxVVhCNVlnYzdZRFBPS0Z6OUxQSzlDZUoxaUV5ek9TSndocWtPK3diSTVja0RteExYSlllRThxSlNGTHV1T20xR0dLS2ZIY0xWQWgvRVV1eHcybTJrSU5Kck5VWUZ2eFhuam5KUlR0MmNqemQrOXBlbFNWaHhOUEEydXIyTHVyZzNpN0dzc2xWT0VLRW5LNGpuNkF6cGJxRlk0ZDh2b1VuMVhQQ0g3VHA5YXpSbDRudGVjZ3dBa00rVW1mZ09vd1UrKzRlQ0o3OG5yZGlNTFFzWUkrbitmZ1dzRVpzaDZldXdMbW1zeFVkK2dZVEltK3NiVmtwNTBoS2pDajREcmZYK0RqeTV3N2M3UE9xRGNXbEZFQ2hnN0FSSDRVUTAwSUJzOXFsZFFwMEdxNXVHakhWMkxJUXNsV2lwcU9PeVk5T2xwbjFhWHlZMzd0S0VSck1UKy9EWFFpeUh2THNyMHhYQXBzZVFlTUtEOWlhV2hTazlhWndvT2pKdVpNdzM1S0o3WVUvTDFxeUZDaXBiNVZCbmZHdnU4a3QvMDhXRnhSZjVlZUNScmlkOUFVZUNtR1lrUTlXd3QvQXRvTWlVWkdzMUp0bk9tQndFdzlSdjBDVTRRQ002ZFdRNXZPUG9mRHZoV0tsTkdvOENvTXdBd3VjME4wTUlCMS9Ja2lQMGw1THhCaGR2SzhHN3BsaW9ZN1cweXpKWlJYeXRvU05WNm4xL2RBNDNsZEFTdUdzNm9GOExad3ZWMWwvaEpnL1pKaEpyTmNXdGkzREFISEZrZTllOWVYVTUyYXpHSVI1bHl4STVPMHFqRi9pTzBuZ3Z4aFlhRDVpYzQ4cFNHRUV2VGJmb0FiMlRkUksvQ0dEV01uNWt5dDgxSlIyamdidEVjUUdDTU5qbXNzSEQvaHVxOWhnejdyZDlOZGNUZDk5aFYxRmVEemJQTnRSdUhkSVJnPT0=', 1, '2025-03-20 11:45:48', 'Admon'),
(2, 1, 'hSyzhr4xiQj/io4/K2Hh9jlSbTd4c2FBU2wrOFp0NWhTeDJMblBkOG9aZmplYU95MWlLT201OW52VGxlMDFJbHN4RnEvdzQ1Qm8rM1VZWkRQeituZ2o5VTNQbmRPMk52VzJ6M3Z0cGNhM3lGOVU2WlhDZ1owM2JPeU1vakptaE0ra2tlWTJEYXJ1L0laMlZMb1l1cnM4NGlYTlk5azdldEFBNnUwbXBDSHJtZ0x3cnM3UW9aanQ1azhRcHg5eldFVFlqWGZWMmhuTkJaZFBHeDlydVdHeGdlZVdGTnoxNEFlZmJZNVV2Y3N3MEU5YnBQaHBpb3FFL0o2WmNJS3hzM2lNMXZkVkZhL0xnRlBYdyt2VVV2QXN2WkpTMlpGaHpQTk8wM0dOb0pvMVdkQVNUbHVVbkxUSmJTM1lrRWlidXNVY1NuMEkwOFNvVzA4b0tueGY4SXozRk5YYzZUMTNSeXJnbmM5SFFFdzl3Y0lsbDVFSnZQN2hPdnpBc1Z5NlBXUDUxV3ZPWTBBcVJrYklQQWMzM2dEeHNVeGhBN091UzBqVTdQbHRQamYyYWpmUW44dUpLYkFybkYxK05ISTRuSEx2SDJNVzJoRlZCaTcyUnppRHhEL0xuYmE2Wmt1L1Rkb1hnb01DV0ZUZ3kzSXh5Q2RiYzVKUWdFT3FRTUdKZ3gyWU5rVnBSZXBJNTFhUkdoZ2lmM1JXbVRmU3B5M2hVSmtmenYvT0gzaTVOZGplRkI1UkVZcDB2TnQ2VTNUa210VTYzY0RNVE9hQzkyTUhjb2FmVUFKd2N3MzlmSUhHd0hLbnpPWkxGMmxjajRDQThHcUYraFhVSFNmcllqQ2hUeTZYSUppN3lGOVNmOURwZUpoS2ZDVFFmck9odmNNRlNDZzRHOHdEcCtMTHJLWTM5VFdvMWtOU25vdE9udFQzb3hBSlY2ZzdnVVNqdFdWeE1zZWN0elF1NEl3NVJWeXplK2RHZVNOSHU5NjBibnhXdGhHRHp5ZnNvUHd6VnJjQjd1NjhLbnp4YkFXK2dWaDN4ZzhHbHh1REJES0h3Tk1oYmx2S2xDeUpBcHpIS205VWxndnBhT2ZDU0x5ZHRyOS84Z3c5c1hpQ1RMSWJQVE41M0MxVjJNQU1JdTFhMzNrSEVnVlR2bnMvUW8yblhoVVBNSE1Nd3FodHBHeHAvd2IydWxkOFYrR1BBempvQlpabHlRaWZpMDNCa1FpQTJhWmh2cmFUaTdOV1duKzd3dTNkdWlMejNEWWlzQVJzUFVueTVIQlVCb2E4eHFVa0JhZmhVT0pMbkJUdU1OcnNHQzFnT2lMZXNuZ3ErdWxZSWpBMzN6azhCUkdTM3EvNWsxQTgvMjcxcnQzMENVNHhxSStyMXpHR1QwR09Zc0c4bXRsTi9YTzZYM0pPMUFDeFJiY0NIU0ljZEM5bkdiMzlha1VEUjFGeDg3dWI2NVhLeUhQU0dFcUZTUHc4d3g2YWpXOG42ZW5ReUpXMnRReUtCaGNjbVg0blh1Ni9qaDFtanAyOUplTEgrazdnbDd1YkJoRDNsS0JXcFVhZ25WeHpyU0pnOVFEZjVCeDJrNUpSd1RhdFphTmV5N2Eya1MzWTFIQko3SkF2Y2ovRmtXT3ZjRHcwdC9zZTdNK1ZxR0tBcDZDbmo3b2hORU1obFluZUxHeUFtTEo4eDdqU2FLc0Vid0lPdTdpZXZXM0tLNTZxRlVqM0cxeXdvQzI1Zm5GZlBnblZUSUtwSEJRejNKMlpjWUNKeXhjbXV6eUd1WjZrY1ZJeXI5M0c2cC9BeTBLSjVQODlDZUJpS0pFUkxwa2hFcnJPaDJPTkUrcEdXaU42ZmU0bTRWMW4yU0oyVEJWZFN4NzVpcEVSQmZNOVVldk8rVDRVRTRRUEVDclZrUEltL1JsQVlRZEVFa2xtd01mYzNXbG5xbGJ4bkpzaHRpeVNQWnJxWmp1MC83c3E1eFliQXNLTElaSm5VRzJmTXhVVVZwaENxUTNQam9PakZKQm9zT3lwbjZQWGxJTHRjQWFkQzFpQ3JxUkQ0d1cxT1VWQ24yblE5cU5XcUR6bFZEVlRyb1ZHMTRhOEQ4NWcxU2RBWVVkTytzcGh1YTN4cDlXV0RhbG5qaHJUK29pMFphMlVVeDBEQ2dqcURLTmZWcG5LOVN5c0RpMSs3RHFkZW5Id2pkZ0xUeHNMeitBek93d0FLMzFkNnlJUFJrR2YrWDNmL1NsTDFyWjU3Mms1czJEUkNmRHRTNmVrUXRzL2k3Y2lOQVc0bDZkZk1PbEpVUUlKUXdUQ05HMHNwTzRMeGpHYzJ2bDk5MUR4UEZWK25wdERrQ1RaVG8yTDJGQjIyeHViU0NHZ1lHMmNDU3phcnE3YnFFOTUzWHNwMHYrTEw5djVhQ0FiN1QwUnZ6eDZsL3RDbzlzdHJRamYreHI1amxwZFBsRUNpYlJ5TGRiY1l6Q0h4UWFpeVRZc1VBVnFuRC9CL1pTN2tmUnY3WXREYnFKMG50NElMbGg5NHNadlV6M3pxVW1DdEhBdFZ3b0FUTkp4NTZYQzVid3crc1d3Z3JHWFBXdDNlaGZDUms4ZkhaZnkrV0hoTFVnaHBRR0Rnd0FiZVBYajBweUIzNmxmaUNkNS9ZclNQcmU5WGtFOWZadEdnSWcrYm1WRlRsWm4wVTZyRlVKWlpyNnFVbVk1Tk1MTnVYdG5FZ2ZwQTNzM0J2MVpMYjB0V3RoNDgrNHpDcllrVGFRdlVQNXpkYll4bThBbVdZWmVJaUQ5eW5VbUt0bWprcWtHem1Hem5DenVFNk9aTHhBdW41UHVpbC85U0krcUtjUC9BZXk1d2ZQZXJlRW9IbnVyMzFRRFdXNHd3Vm5Hd0ZpQ200eFRVQ0RMQ2VvbVlSM1NmdWhKcVd3VTZWQlNWZ1JzbC84M3lQcVRDeGU3RnR2M3k0RFErWUxaajQvSDBiZFJZR0Z5eHdwZEVRVTlyWStNWVhwSWtseFdMdlF3bGxJQ3hFZnJhdHp2ZjR0Y25oWGlvVlFZam1pVENxUU96RGU0RzdpY2ZhS29wNlhGUmpDQmRtUENVc2FsdWQ1MUZwaUJqR2pTN2x6U0dmcmE3aUU0a2xweXloOWpJMlowTVlqeHVzcTlmUnNZRkJVU2VDZUZkR2cxZ1BjSzhseUxhdjRxT3VyNDdnY3dxNGtxeFdZRm9BOFdKenhTbDN5dlhjdlpsc0xMazJ5NjhjVmtaT0pXWkcrUTNxOGtWZm1KTGwyaEtUeXJOWm8ya3JTZFVqYzdOUXI4dFlqdU91SWpnTkR5ekpMdFZuMGtMRnhFbE5aWk9UK2Z3MkdTaVhGeCtIWXc0V0RKUzJ3ZHlRb0hBdzVrZXErQzUyQ3lNZGtoUHU2ZkdsQTRVTFRDTTNuMEI3QnJsRW9PeFRORVROTFJIZDNFTjVCekZ2SFZnS3FNZkVwc2dVeFd2UnF6cldjcVRLcCtvbURoK3RlTWZKaDl2dHNqbkJOL3h5Nllod1pGeHVvU3I1bUJlcSt0cVlROTE1dVZxRDNoV1ZURXJIdWtqUVJQRVh1NTZZeVN0TWlnZXo4S1VsQ3o0b2dPVWZVczVPdXl6VEFsV2FqWlVPdWJadUloR0ZQY1QxRHFwMmtNdlNIZlRiS1J4Z0I2bExGVHFEeDlxYzFiQnhPUE5jc3Q4ZUFJdHFSZnhWbGVTQ2R2Zi9IR0I0TVliMGQyUTE2NDVBTkVMR0QxeWtYa1ZCZm8zNHJGa2lPVXZVb0p1eWFTUW9tV3dsbGU5RnpkdHFxVVhCNVlnYzdZRFBPS0Z6OUxQSzlDZUoxaUV5ek9TSndocWtPK3diSTVja0RteExYSlllRThxSlNGTHV1T20xR0dLS2ZIY0xWQWgvRVV1eHcybTJrSU5Kck5VWUZ2eFhuam5KUlR0MmNqemQrOXBlbFNWaHhOUEEydXIyTHVyZzNpN0dzc2xWT0VLRW5LNGpuNkF6cGJxRlk0ZDh2b1VuMVhQQ0g3VHA5YXpSbDRudGVjZ3dBa00rVW1mZ09vd1UrKzRlQ0o3OG5yZGlNTFFzWUkrbitmZ1dzRVpzaDZldXdMbW1zeFVkK2dZVEltK3NiVmtwNTBoS2pDajREcmZYK0RqeTV3N2M3UE9xRGNXbEZFQ2hnN0FSSDRVUTAwSUJzOXFsZFFwMEdxNXVHakhWMkxJUXNsV2lwcU9PeVk5T2xwbjFhWHlZMzd0S0VSck1UKy9EWFFpeUh2THNyMHhYQXBzZVFlTUtEOWlhV2hTazlhWndvT2pKdVpNdzM1S0o3WVUvTDFxeUZDaXBiNVZCbmZHdnU4a3QvMDhXRnhSZjVlZUNScmlkOUFVZUNtR1lrUTlXd3QvQXRvTWlVWkdzMUp0bk9tQndFdzlSdjBDVTRRQ002ZFdRNXZPUG9mRHZoV0tsTkdvOENvTXdBd3VjME4wTUlCMS9Ja2lQMGw1THhCaGR2SzhHN3BsaW9ZN1cweXpKWlJYeXRvU05WNm4xL2RBNDNsZEFTdUdzNm9GOExad3ZWMWwvaEpnL1pKaEpyTmNXdGkzREFISEZrZTllOWVYVTUyYXpHSVI1bHl4STVPMHFqRi9pTzBuZ3Z4aFlhRDVpYzQ4cFNHRUV2VGJmb0FiMlRkUksvQ0dEV01uNWt5dDgxSlIyamdidEVjUUdDTU5qbXNzSEQvaHVxOWhnejdyZDlOZGNUZDk5aFYxRmVEemJQTnRSdUhkSVJnPT0=', 1, '2025-03-21 11:53:04', 'Admon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templeado`
--

CREATE TABLE `templeado` (
  `COD_EMPLEADO` int(11) NOT NULL,
  `COD_USUARIO` int(11) DEFAULT NULL,
  `NOM_EMPLEADO` varchar(20) DEFAULT NULL,
  `APE1_EMPLEADO` varchar(20) DEFAULT NULL,
  `APE2_EMPLEADO` varchar(20) DEFAULT NULL,
  `CONTACTO_EMPLEADO` varchar(20) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL,
  `FEC_BAJA` datetime DEFAULT NULL,
  `NOM_USUARIO_BAJA` varchar(20) DEFAULT NULL,
  `FOTO` varchar(30) DEFAULT NULL,
  `HORARIO` varchar(30) DEFAULT NULL,
  `FLEX` tinyint(1) DEFAULT NULL,
  `MAX_HORA_DIA` int(2) DEFAULT NULL,
  `BOLSA_HORAS` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `templeado`
--

INSERT INTO `templeado` (`COD_EMPLEADO`, `COD_USUARIO`, `NOM_EMPLEADO`, `APE1_EMPLEADO`, `APE2_EMPLEADO`, `CONTACTO_EMPLEADO`, `FEC_ALTA`, `NOM_USUARIO_ALTA`, `FEC_BAJA`, `NOM_USUARIO_BAJA`, `FOTO`, `HORARIO`, `FLEX`, `MAX_HORA_DIA`, `BOLSA_HORAS`) VALUES
(1, 2, 'David', 'Martín', 'Prados', 'David@david.com', '2025-03-20 11:32:41', 'admon', NULL, NULL, 'emp_0001_da_ma_pr.jpg', '8h a 19h', 1, 6, 4.42),
(3, 1, 'Juan', 'Perez', 'Gomez', 'juanpg@local.com', '2025-03-20 11:34:57', 'admon', NULL, NULL, 'emp_0002_ju_pe_go.jpg', '8h a 16h', 0, 8, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmarcaje`
--

CREATE TABLE `tmarcaje` (
  `COD_MARCAJE` bigint(20) NOT NULL,
  `COD_TIPO_MARCAJE` int(11) DEFAULT NULL,
  `COD_EMPLEADO` int(11) DEFAULT NULL,
  `COD_BIO` int(11) DEFAULT NULL,
  `DES_FOTO` varchar(30) DEFAULT NULL,
  `COD_TIPO_ACCESO` int(11) DEFAULT NULL,
  `FEC_MARCAJE` datetime DEFAULT NULL,
  `HOR_MARCAJE` datetime DEFAULT NULL,
  `FEC_GRABACION` datetime DEFAULT NULL,
  `HOR_GRABACION` datetime DEFAULT NULL,
  `IND_INCIDENCIA` tinyint(1) DEFAULT NULL,
  `IND_PENDIENTE` tinyint(1) DEFAULT NULL,
  `DES_OBSERVACIONES` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmarcaje`
--

INSERT INTO `tmarcaje` (`COD_MARCAJE`, `COD_TIPO_MARCAJE`, `COD_EMPLEADO`, `COD_BIO`, `DES_FOTO`, `COD_TIPO_ACCESO`, `FEC_MARCAJE`, `HOR_MARCAJE`, `FEC_GRABACION`, `HOR_GRABACION`, `IND_INCIDENCIA`, `IND_PENDIENTE`, `DES_OBSERVACIONES`) VALUES
(1, 1, 1, 1, 'foto', 1, '2025-03-20 11:48:24', NULL, '2025-03-20 11:48:24', NULL, 0, 1, 'observaciones'),
(24, 1, 1, 2, 'empleado_1_1742819095.jpg', 1, '2025-03-24 12:24:55', NULL, '2025-03-24 13:24:55', NULL, 0, 0, ''),
(25, 2, 1, 2, 'empleado_1_1742819161.jpg', 1, '2025-03-24 12:26:01', NULL, '2025-03-24 13:26:01', NULL, 0, 0, ''),
(26, 1, 1, 2, 'empleado_1_1742829918.jpg', 1, '2025-03-24 15:25:18', NULL, '2025-03-24 16:25:18', NULL, 0, 0, ''),
(27, 2, 1, 2, 'empleado_1_1742830016.jpg', 1, '2025-03-24 15:26:56', NULL, '2025-03-24 16:26:56', NULL, 0, 0, ''),
(28, 1, 1, 2, 'empleado_1_1742832595.jpg', 1, '2025-03-24 16:09:55', NULL, '2025-03-24 17:09:55', NULL, 0, 0, ''),
(29, 2, 1, 2, 'empleado_1_1742837544.jpg', 1, '2025-03-24 17:32:24', NULL, '2025-03-24 18:32:24', NULL, 0, 0, ''),
(30, 1, 1, 2, 'empleado_1_1742889590.jpg', 1, '2025-03-25 07:59:50', NULL, '2025-03-25 08:59:50', NULL, 0, 0, ''),
(31, 2, 1, 2, 'empleado_1_1742891899.jpg', 1, '2025-03-25 08:38:19', NULL, '2025-03-25 09:38:19', NULL, 0, 0, ''),
(32, 1, 1, 2, 'empleado_1_1742900460.jpg', 1, '2025-03-25 11:01:00', NULL, '2025-03-25 12:01:00', NULL, 0, 0, ''),
(33, 2, 1, 2, 'empleado_1_1742916423.jpg', 1, '2025-03-25 15:27:02', NULL, '2025-03-25 16:27:03', NULL, 0, 0, ''),
(34, 1, 1, 2, 'empleado_1_1742819095.jpg', 1, '2025-03-21 08:04:05', NULL, '2025-03-21 08:04:05', NULL, 0, 0, ''),
(35, 2, 1, 2, 'empleado_1_1742819161.jpg', 1, '2025-03-21 14:06:01', NULL, '2025-03-21 14:06:01', NULL, 0, 0, ''),
(36, 1, 1, 2, 'empleado_1_1742819095.jpg', 1, '2025-03-21 16:06:01', NULL, '2025-03-21 16:06:01', NULL, 0, 0, ''),
(37, 2, 1, 2, 'empleado_1_1742819161.jpg', 1, '2025-03-21 18:16:22', NULL, '2025-03-21 18:16:22', NULL, 0, 0, ''),
(38, 1, 1, 2, 'empleado_1_1742819095.jpg', 1, '2025-03-24 08:00:55', NULL, '2025-03-24 08:00:55', NULL, 0, 0, ''),
(39, 2, 1, 2, 'empleado_1_1742819161.jpg', 1, '2025-03-24 12:05:12', NULL, '2025-03-24 12:05:12', NULL, 0, 0, ''),
(40, 1, 1, 2, 'empleado_1_1742819095.jpg', 1, '2025-03-20 08:02:00', NULL, '2025-03-20 08:02:00', NULL, 0, 0, ''),
(41, 2, 1, 2, 'empleado_1_1742819161.jpg', 1, '2025-03-20 14:03:03', NULL, '2025-03-20 14:03:03', NULL, 0, 0, ''),
(42, 1, 1, 2, 'empleado_1_1742819095.jpg', 1, '2025-03-20 16:10:25', NULL, '2025-03-20 16:10:25', NULL, 0, 0, ''),
(43, 2, 1, 2, 'empleado_1_1742819161.jpg', 1, '2025-03-20 18:07:35', NULL, '2025-03-20 18:07:35', NULL, 0, 0, ''),
(44, 1, 1, 2, 'empleado_1_1742819095.jpg', 1, '2025-03-19 08:07:01', NULL, '2025-03-19 08:07:01', NULL, 0, 0, ''),
(45, 2, 1, 2, 'empleado_1_1742819161.jpg', 1, '2025-03-19 16:12:01', NULL, '2025-03-19 16:12:01', NULL, 0, 0, ''),
(46, 1, 1, 2, 'empleado_1_1742919496.jpg', 1, '2025-03-25 17:18:16', NULL, '2025-03-25 17:18:16', NULL, 0, 0, ''),
(47, 2, 1, 2, 'empleado_1_1742819161.jpg', 1, '2025-03-25 18:59:01', NULL, '2025-03-25 18:59:01', NULL, 0, 0, ''),
(48, 1, 1, 2, 'empleado_1_1742981114.jpg', 1, '2025-03-26 10:25:13', NULL, '2025-03-26 10:25:14', NULL, 0, 0, ''),
(49, 2, 1, 2, 'empleado_1_1742981762.jpg', 1, '2025-03-26 10:36:02', NULL, '2025-03-26 10:36:02', NULL, 0, 0, ''),
(50, 1, 1, 2, 'empleado_1_1742982244.jpg', 1, '2025-03-26 10:44:04', NULL, '2025-03-26 10:44:04', NULL, 0, 0, ''),
(51, 1, 1, 2, 'empleado_1_1742819095.jpg', 99, '2025-03-17 08:00:00', NULL, '2025-03-17 08:00:00', NULL, 0, 0, ''),
(52, 2, 1, 2, 'empleado_1_1742819095.jpg', 99, '2025-03-17 14:00:00', NULL, '2025-03-17 14:00:00', NULL, 0, 0, ''),
(53, 2, 1, 2, 'empleado_1_1743011885.jpg', 1, '2025-03-26 18:58:05', NULL, '2025-03-26 18:58:05', NULL, 0, 0, ''),
(54, 1, 1, 2, 'empleado_1_1743060817.jpg', 1, '2025-03-27 08:33:37', NULL, '2025-03-27 08:33:37', NULL, 0, 0, ''),
(55, 2, 1, 2, 'empleado_1_1743080252.jpg', 1, '2025-03-27 13:57:32', NULL, '2025-03-27 13:57:32', NULL, 0, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trevisiones`
--

CREATE TABLE `trevisiones` (
  `ID` int(10) NOT NULL COMMENT 'ID de la incidencia',
  `FECHA_REV` date DEFAULT NULL COMMENT 'Fecha de la solicitud',
  `FECHA_INC` date DEFAULT NULL COMMENT 'Fecha sobre la que trata la incidencia',
  `COMENTARIO` text DEFAULT NULL COMMENT 'Comentario del empleado',
  `PRIORIDAD` int(1) DEFAULT NULL COMMENT 'Prioridad dada por el empelado',
  `EMPLEADO` int(2) DEFAULT NULL COMMENT 'Código del empleado',
  `RESUELTA` tinyint(1) DEFAULT NULL COMMENT 'Estado de la incidencia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trevisiones`
--

INSERT INTO `trevisiones` (`ID`, `FECHA_REV`, `FECHA_INC`, `COMENTARIO`, `PRIORIDAD`, `EMPLEADO`, `RESUELTA`) VALUES
(1, '2025-03-27', '2025-03-24', 'ddd', 0, 1, 0),
(2, '2025-03-27', '2025-03-27', 'Horas Extras', 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trol`
--

CREATE TABLE `trol` (
  `COD_ROL` int(11) NOT NULL,
  `NOM_ROL` varchar(20) DEFAULT NULL,
  `DES_ROL` varchar(100) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL,
  `FEC_BAJA` datetime DEFAULT NULL,
  `NOM_USUARIO_BAJA` varchar(20) DEFAULT NULL,
  `PRIVILEGIOS` text DEFAULT NULL COMMENT 'Array de privilegios'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trol`
--

INSERT INTO `trol` (`COD_ROL`, `NOM_ROL`, `DES_ROL`, `FEC_ALTA`, `NOM_USUARIO_ALTA`, `FEC_BAJA`, `NOM_USUARIO_BAJA`, `PRIVILEGIOS`) VALUES
(1, 'Conserje', 'Acceso a la aplicación de reconocimiento', '2025-03-20 11:40:27', 'Admon', NULL, NULL, 'O:17:\"Clases\\Privilegio\":20:{s:27:\"\0Clases\\Privilegio\0empCrear\";b:0;s:31:\"\0Clases\\Privilegio\0empModificar\";b:0;s:26:\"\0Clases\\Privilegio\0empBaja\";b:0;s:27:\"\0Clases\\Privilegio\0usrCrear\";b:0;s:31:\"\0Clases\\Privilegio\0usrModificar\";b:0;s:26:\"\0Clases\\Privilegio\0usrBaja\";b:0;s:33:\"\0Clases\\Privilegio\0usrGenerarPass\";b:0;s:33:\"\0Clases\\Privilegio\0marCrearPropio\";b:0;s:37:\"\0Clases\\Privilegio\0marConsultarPropio\";b:0;s:27:\"\0Clases\\Privilegio\0marCrear\";b:0;s:31:\"\0Clases\\Privilegio\0marModificar\";b:0;s:30:\"\0Clases\\Privilegio\0marEliminar\";b:0;s:31:\"\0Clases\\Privilegio\0marConsultar\";b:0;s:26:\"\0Clases\\Privilegio\0marAuth\";b:0;s:27:\"\0Clases\\Privilegio\0bioCrear\";b:0;s:30:\"\0Clases\\Privilegio\0bioEliminar\";b:0;s:27:\"\0Clases\\Privilegio\0rolCrear\";b:0;s:31:\"\0Clases\\Privilegio\0rolModificar\";b:0;s:30:\"\0Clases\\Privilegio\0rolEliminar\";b:0;s:35:\"\0Clases\\Privilegio\0ajustesModificar\";b:0;}'),
(2, 'Admin', 'Acceso al portal de administración', '2025-03-20 11:48:41', 'Admon', NULL, NULL, 'O:17:\"Clases\\Privilegio\":20:{s:27:\"\0Clases\\Privilegio\0empCrear\";b:0;s:31:\"\0Clases\\Privilegio\0empModificar\";b:0;s:26:\"\0Clases\\Privilegio\0empBaja\";b:0;s:27:\"\0Clases\\Privilegio\0usrCrear\";b:0;s:31:\"\0Clases\\Privilegio\0usrModificar\";b:0;s:26:\"\0Clases\\Privilegio\0usrBaja\";b:0;s:33:\"\0Clases\\Privilegio\0usrGenerarPass\";b:0;s:33:\"\0Clases\\Privilegio\0marCrearPropio\";b:0;s:37:\"\0Clases\\Privilegio\0marConsultarPropio\";b:0;s:27:\"\0Clases\\Privilegio\0marCrear\";b:0;s:31:\"\0Clases\\Privilegio\0marModificar\";b:0;s:30:\"\0Clases\\Privilegio\0marEliminar\";b:0;s:31:\"\0Clases\\Privilegio\0marConsultar\";b:0;s:26:\"\0Clases\\Privilegio\0marAuth\";b:0;s:27:\"\0Clases\\Privilegio\0bioCrear\";b:0;s:30:\"\0Clases\\Privilegio\0bioEliminar\";b:0;s:27:\"\0Clases\\Privilegio\0rolCrear\";b:0;s:31:\"\0Clases\\Privilegio\0rolModificar\";b:0;s:30:\"\0Clases\\Privilegio\0rolEliminar\";b:0;s:35:\"\0Clases\\Privilegio\0ajustesModificar\";b:0;}'),
(3, 'Empleado', 'Acceso al portal de empleado', '2025-03-20 11:48:41', 'Admon', NULL, NULL, 'O:17:\"Clases\\Privilegio\":20:{s:27:\"\0Clases\\Privilegio\0empCrear\";b:0;s:31:\"\0Clases\\Privilegio\0empModificar\";b:0;s:26:\"\0Clases\\Privilegio\0empBaja\";b:0;s:27:\"\0Clases\\Privilegio\0usrCrear\";b:0;s:31:\"\0Clases\\Privilegio\0usrModificar\";b:0;s:26:\"\0Clases\\Privilegio\0usrBaja\";b:0;s:33:\"\0Clases\\Privilegio\0usrGenerarPass\";b:0;s:33:\"\0Clases\\Privilegio\0marCrearPropio\";b:0;s:37:\"\0Clases\\Privilegio\0marConsultarPropio\";b:0;s:27:\"\0Clases\\Privilegio\0marCrear\";b:0;s:31:\"\0Clases\\Privilegio\0marModificar\";b:0;s:30:\"\0Clases\\Privilegio\0marEliminar\";b:0;s:31:\"\0Clases\\Privilegio\0marConsultar\";b:0;s:26:\"\0Clases\\Privilegio\0marAuth\";b:0;s:27:\"\0Clases\\Privilegio\0bioCrear\";b:0;s:30:\"\0Clases\\Privilegio\0bioEliminar\";b:0;s:27:\"\0Clases\\Privilegio\0rolCrear\";b:0;s:31:\"\0Clases\\Privilegio\0rolModificar\";b:0;s:30:\"\0Clases\\Privilegio\0rolEliminar\";b:0;s:35:\"\0Clases\\Privilegio\0ajustesModificar\";b:0;}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttbio`
--

CREATE TABLE `ttbio` (
  `COD_TIPO_BIO` int(11) NOT NULL,
  `DES_TIPO_BIO` varchar(20) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL,
  `FEC_BAJA` datetime DEFAULT NULL,
  `NOM_USUARIO_BAJA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ttbio`
--

INSERT INTO `ttbio` (`COD_TIPO_BIO`, `DES_TIPO_BIO`, `FEC_ALTA`, `NOM_USUARIO_ALTA`, `FEC_BAJA`, `NOM_USUARIO_BAJA`) VALUES
(1, 'Facial', '2025-03-16 11:39:02', 'Admon', NULL, NULL),
(2, 'RFID', '2025-03-16 11:39:02', 'Admon', NULL, NULL),
(3, 'Teclado', '2025-03-20 11:54:22', 'Admon', NULL, NULL),
(7, 'Keypad', '2025-03-20 12:16:02', 'Admon', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttipoacceso`
--

CREATE TABLE `ttipoacceso` (
  `COD_TIPO_ACCESO` int(11) NOT NULL,
  `DES_TIPO_ACCESO` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ttipoacceso`
--

INSERT INTO `ttipoacceso` (`COD_TIPO_ACCESO`, `DES_TIPO_ACCESO`) VALUES
(1, 'RecFacial'),
(2, 'RFID'),
(99, 'AUSENCIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttransacciones`
--

CREATE TABLE `ttransacciones` (
  `COD_TRANSACCION` bigint(20) NOT NULL,
  `TIP_TRANS` varchar(5) DEFAULT NULL,
  `DESC_TRANS` varchar(30) DEFAULT NULL,
  `COD_OBJ` int(11) DEFAULT NULL,
  `NOM_OBJ` varchar(20) DEFAULT NULL,
  `COD_USUARIO` int(11) DEFAULT NULL,
  `FEC_SIS` datetime DEFAULT NULL,
  `HOR_SIS` datetime DEFAULT NULL,
  `IP_USUARIO` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ttransacciones`
--

INSERT INTO `ttransacciones` (`COD_TRANSACCION`, `TIP_TRANS`, `DESC_TRANS`, `COD_OBJ`, `NOM_OBJ`, `COD_USUARIO`, `FEC_SIS`, `HOR_SIS`, `IP_USUARIO`) VALUES
(6, 'mod_u', 'Modificación del usuario Admon', 1, 'tUsuario', 1, '2025-03-20 13:30:43', NULL, '127.0.0.1'),
(7, 'mod_u', 'Modificación del usuario Admon', 1, 'tUsuario', 1, '2025-03-20 13:31:02', NULL, '127.0.0.1'),
(8, 'mod_u', 'Modificación del usuario Admon', 1, 'tUsuario', 1, '2025-03-20 13:31:17', NULL, '127.0.0.1'),
(9, 'mod_u', 'Modificación del usuario Admon', 1, 'tUsuario', 1, '2025-03-20 13:36:53', NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tusuario`
--

CREATE TABLE `tusuario` (
  `COD_USUARIO` int(11) NOT NULL,
  `NOM_LOGIN` varchar(20) DEFAULT NULL,
  `DES_CONTRASENA` varchar(100) DEFAULT NULL,
  `DES_CORREO` varchar(20) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL,
  `FEC_BAJA` datetime DEFAULT NULL,
  `NOM_USUARIO_BAJA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tusuario`
--

INSERT INTO `tusuario` (`COD_USUARIO`, `NOM_LOGIN`, `DES_CONTRASENA`, `DES_CORREO`, `FEC_ALTA`, `NOM_USUARIO_ALTA`, `FEC_BAJA`, `NOM_USUARIO_BAJA`) VALUES
(1, 'Admon', '$2y$10$wmG1sV.DKtBGmElbfJvdNezoKWvene1rOui8jJU48e01USIybXdVO', 'benito@sefue.com', '2025-03-20 12:32:57', 'Admon', NULL, NULL),
(2, 'David', '$2y$10$wmG1sV.DKtBGmElbfJvdNezoKWvene1rOui8jJU48e01USIybXdVO', 'david@david.com', '2025-03-25 09:39:30', 'Admon', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tusuariorol`
--

CREATE TABLE `tusuariorol` (
  `COD_USUARIO` int(11) DEFAULT NULL,
  `COD_ROL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tusuariorol`
--

INSERT INTO `tusuariorol` (`COD_USUARIO`, `COD_ROL`) VALUES
(1, 1),
(2, 3),
(2, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tajuste`
--
ALTER TABLE `tajuste`
  ADD PRIMARY KEY (`ID_AJUSTE`);

--
-- Indices de la tabla `tbio`
--
ALTER TABLE `tbio`
  ADD PRIMARY KEY (`COD_BIO`),
  ADD KEY `COD_EMPLEADO` (`COD_EMPLEADO`),
  ADD KEY `COD_TIPO_BIO` (`COD_TIPO_BIO`);

--
-- Indices de la tabla `templeado`
--
ALTER TABLE `templeado`
  ADD PRIMARY KEY (`COD_EMPLEADO`),
  ADD UNIQUE KEY `COD_USUARIO` (`COD_USUARIO`);

--
-- Indices de la tabla `tmarcaje`
--
ALTER TABLE `tmarcaje`
  ADD PRIMARY KEY (`COD_MARCAJE`),
  ADD KEY `COD_EMPLEADO` (`COD_EMPLEADO`),
  ADD KEY `COD_BIO` (`COD_BIO`),
  ADD KEY `COD_TIPO_ACCESO` (`COD_TIPO_ACCESO`);

--
-- Indices de la tabla `trevisiones`
--
ALTER TABLE `trevisiones`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `trol`
--
ALTER TABLE `trol`
  ADD PRIMARY KEY (`COD_ROL`);

--
-- Indices de la tabla `ttbio`
--
ALTER TABLE `ttbio`
  ADD PRIMARY KEY (`COD_TIPO_BIO`);

--
-- Indices de la tabla `ttipoacceso`
--
ALTER TABLE `ttipoacceso`
  ADD PRIMARY KEY (`COD_TIPO_ACCESO`);

--
-- Indices de la tabla `ttransacciones`
--
ALTER TABLE `ttransacciones`
  ADD PRIMARY KEY (`COD_TRANSACCION`),
  ADD KEY `COD_USUARIO` (`COD_USUARIO`);

--
-- Indices de la tabla `tusuario`
--
ALTER TABLE `tusuario`
  ADD PRIMARY KEY (`COD_USUARIO`);

--
-- Indices de la tabla `tusuariorol`
--
ALTER TABLE `tusuariorol`
  ADD KEY `COD_USUARIO` (`COD_USUARIO`),
  ADD KEY `COD_ROL` (`COD_ROL`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tajuste`
--
ALTER TABLE `tajuste`
  MODIFY `ID_AJUSTE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbio`
--
ALTER TABLE `tbio`
  MODIFY `COD_BIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `templeado`
--
ALTER TABLE `templeado`
  MODIFY `COD_EMPLEADO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tmarcaje`
--
ALTER TABLE `tmarcaje`
  MODIFY `COD_MARCAJE` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `trevisiones`
--
ALTER TABLE `trevisiones`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID de la incidencia', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `trol`
--
ALTER TABLE `trol`
  MODIFY `COD_ROL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ttbio`
--
ALTER TABLE `ttbio`
  MODIFY `COD_TIPO_BIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ttipoacceso`
--
ALTER TABLE `ttipoacceso`
  MODIFY `COD_TIPO_ACCESO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `ttransacciones`
--
ALTER TABLE `ttransacciones`
  MODIFY `COD_TRANSACCION` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tusuario`
--
ALTER TABLE `tusuario`
  MODIFY `COD_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbio`
--
ALTER TABLE `tbio`
  ADD CONSTRAINT `tbio_ibfk_1` FOREIGN KEY (`COD_EMPLEADO`) REFERENCES `templeado` (`COD_EMPLEADO`),
  ADD CONSTRAINT `tbio_ibfk_2` FOREIGN KEY (`COD_TIPO_BIO`) REFERENCES `ttbio` (`COD_TIPO_BIO`);

--
-- Filtros para la tabla `tmarcaje`
--
ALTER TABLE `tmarcaje`
  ADD CONSTRAINT `tmarcaje_ibfk_1` FOREIGN KEY (`COD_EMPLEADO`) REFERENCES `templeado` (`COD_EMPLEADO`),
  ADD CONSTRAINT `tmarcaje_ibfk_2` FOREIGN KEY (`COD_BIO`) REFERENCES `tbio` (`COD_BIO`),
  ADD CONSTRAINT `tmarcaje_ibfk_3` FOREIGN KEY (`COD_TIPO_ACCESO`) REFERENCES `ttipoacceso` (`COD_TIPO_ACCESO`);

--
-- Filtros para la tabla `ttransacciones`
--
ALTER TABLE `ttransacciones`
  ADD CONSTRAINT `ttransacciones_ibfk_1` FOREIGN KEY (`COD_USUARIO`) REFERENCES `tusuario` (`COD_USUARIO`);

--
-- Filtros para la tabla `tusuario`
--
ALTER TABLE `tusuario`
  ADD CONSTRAINT `tusuario_ibfk_1` FOREIGN KEY (`COD_USUARIO`) REFERENCES `templeado` (`COD_USUARIO`);

--
-- Filtros para la tabla `tusuariorol`
--
ALTER TABLE `tusuariorol`
  ADD CONSTRAINT `tusuariorol_ibfk_1` FOREIGN KEY (`COD_USUARIO`) REFERENCES `tusuario` (`COD_USUARIO`),
  ADD CONSTRAINT `tusuariorol_ibfk_2` FOREIGN KEY (`COD_ROL`) REFERENCES `trol` (`COD_ROL`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
