import { useRef } from 'react'
import { Head, useForm, usePage } from '@inertiajs/react'

const OtpInput = () => {
    const { flash } = usePage().props

    const { data, setData, post, processing, errors, transform } = useForm({
        otp: ['', '', '', '', '', ''],
    })

    const inputsRef = useRef([])

    const handleChange = (index, value) => {
        if (!/^\d?$/.test(value)) return

        const updatedOtp = [...data.otp]
        updatedOtp[index] = value
        setData('otp', updatedOtp)

        if (value && index < 5) {
            inputsRef.current[index + 1].focus()
        }
    }

    const handleKeyDown = (e, index) => {
        if (e.key === 'Backspace' && !data.otp[index] && index > 0) {
            inputsRef.current[index - 1].focus()
        }
    }

    const handleSubmit = (e) => {
        e.preventDefault()
        transform(({ otp }) => ({
            otp: otp.join('')
        }))
        post(route('otp.verify'))
    }

    const handleResendOtp = (e) => {
        e.preventDefault()
        post(route('otp.resend'))
    }

    return (
        <>
            <Head title='Verifikasi OTP' />
            <div className="min-h-screen bg-gray-50 flex items-center justify-center px-4">
                <div className="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
                    <h1 className="text-3xl font-bold text-center text-[#008970] mb-2">Masukkan Kode OTP</h1>
                    <p className="text-gray-600 text-center mb-6 text-sm">
                        Kami telah mengirimkan kode 6 digit ke email Anda.
                    </p>

                    <form onSubmit={handleSubmit}>
                        <div className="flex justify-between gap-2 mb-6">
                            {data.otp.map((digit, index) => (
                                <input
                                    key={index}
                                    type="text"
                                    maxLength="1"
                                    inputMode="numeric"
                                    pattern="[0-9]*"
                                    value={digit}
                                    onChange={(e) => handleChange(index, e.target.value)}
                                    onKeyDown={(e) => handleKeyDown(e, index)}
                                    ref={(el) => (inputsRef.current[index] = el)}
                                    className="w-12 h-14 text-center border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#008970] text-lg font-medium"
                                    required
                                />
                            ))}
                        </div>

                        {errors.otp && (
                            <div className="text-red-500 text-sm mb-4 text-center">{errors.otp}</div>
                        )}

                        {flash.success && (
                            <div className="text-green-500 text-sm mb-4 text-center">{flash.success}</div>
                        )}

                        {flash.status && (
                            <div className="text-green-500 text-sm mb-4 text-center">{flash.status}</div>
                        )}

                        {flash.error && (
                            <div className="text-red-500 text-sm mb-4 text-center">{flash.error}</div>
                        )}

                        <button
                            type="submit"
                            disabled={processing}
                            className={`flex gap-2 items-center justify-center w-full ${processing && 'bg-shades/70 disabled:cursor-not-allowed disabled:opacity-60'} bg-shades hover:bg-emerald-800 text-white font-semibold py-3 rounded-md transition duration-200`}
                        >
                            {
                                processing
                                    ?
                                    <>
                                        <span className="h-4 w-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                        <span>Loading</span>
                                    </>
                                    :
                                    'Verifikasi'

                            }
                        </button>

                    </form>

                    <form onSubmit={handleResendOtp} className='mt-5'>
                        <span className="text-center text-sm text-gray-600">
                            Tidak menerima kode?
                            <button type="submit"
                                className="text-[#008970] hover:underline font-medium ml-1">
                                Kirim Ulang Kode Verifikasi
                            </button>
                        </span>
                    </form>

                </div>
            </div>
        </>
    )
}

export default OtpInput
