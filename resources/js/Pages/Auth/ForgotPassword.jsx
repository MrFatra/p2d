import { Head, useForm, usePage } from '@inertiajs/react';
import { FaArrowRight } from 'react-icons/fa'

export default function ForgotPassword() {
    const { flash } = usePage().props

    const { data, setData, post, processing, errors, wasSuccessful } = useForm({
        email: '',
    });

    function submit(e) {
        e.preventDefault();
        post(route('password.send-email'));
    }

    return (
        <>
            <Head title='Lupa Password' />
            <div className="flex justify-center items-center min-h-screen bg-gray-100">
                <div className="w-full max-w-md p-8 space-y-3 bg-white rounded-xl shadow-md">
                    <h1 className="text-3xl font-bold text-center">Lupa Password</h1>
                    <p className="text-center text-gray-500 text-sm">Masukkan alamat email Anda, dan kami akan mengirimkan tautan untuk mereset kata sandi Anda.</p>

                    {flash.status && <div className="mb-4 font-medium text-sm text-green-600">{flash.status}</div>}

                    <form onSubmit={submit}>
                        <div className='my-5'>
                            <label htmlFor="email" className="sr-only">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                autoComplete="username"
                                onChange={(e) => {
                                    setData('email', e.target.value)
                                    if (errors.email) errors.email = null
                                }}
                                className={`shadow border ${errors.email ? 'border-red-500' : 'border-gray-300 focus:border-custom-emerald focus:ring-custom-emerald focus:ring-1'} rounded-lg w-full p-3 mb-3 leading-tight focus:outline-none font-medium md:text-base text-sm`}
                                placeholder="Email"
                            />
                            {errors.email && <div className="text-red-500 text-sm">{errors.email}</div>}
                            <blockquote className="p-4 my-4 border-l-4 border-amber-500 bg-amber-50 text-amber-800 italic rounded text-sm">
                                NOTE: Pastikan alamat email yang diisi adalah alamat email yang valid.
                            </blockquote>
                        </div>

                        <div className="flex flex-col gap-3 items-center justify-end mt-4">
                            <button
                                type="submit"
                                className={`flex gap-2 items-center justify-center w-full ${processing && 'bg-shades/70 disabled:cursor-not-allowed disabled:opacity-60'} bg-shades hover:bg-emerald-800 text-white font-semibold py-3 rounded-md transition duration-200`}
                                disabled={processing}
                            >
                                {
                                    processing
                                        ?
                                        <>
                                            <span className="h-4 w-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                            <span>Loading</span>
                                        </>
                                        :
                                        <>
                                            <span>
                                                Kirim Email
                                            </span>
                                            <FaArrowRight />
                                        </>

                                }
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}
